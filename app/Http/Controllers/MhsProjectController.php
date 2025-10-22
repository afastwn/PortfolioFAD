<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MhsProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:mahasiswa']);
    }

    // ================== MyWorks (grid 1..8) ==================
    public function index()
    {
        $user = Auth::user();

        $bySemester = $user->projects()
            ->latest('id')
            ->get()
            ->keyBy('semester');

        $semesters = [];
        for ($s = 1; $s <= 8; $s++) {
            /** @var \App\Models\Project|null $p */
            $p = $bySemester->get($s);
            $semesters[] = [
                'semester'  => $s,
                'project'   => $p,
                'cover_url' => $p?->display_cover_url, // dari Display Photo[0]
                'exists'    => (bool) $p,
            ];
        }

        $hasAny       = $bySemester->isNotEmpty();
        $lastSemester = (int) $user->projects()->max('semester'); // null => 0
        $nextSemester = $lastSemester ? $lastSemester + 1 : 1;    // 1..9

        return view('mhs.myWorksMhs', compact('semesters', 'hasAny', 'nextSemester'));
    }

    // ================== Form Add Project ==================
    public function create()
    {
        $currentAnonim = Auth::user()
            ->projects()
            ->whereNotNull('anonim_name')
            ->orderBy('semester')
            ->value('anonim_name');

        return view('mhs.addProjectMhs',compact('currentAnonim'));
    }

    // ================== Simpan Project (semester otomatis) ==================
    public function store(Request $request)
    {
        $user = Auth::user();

        // Tentukan semester berikutnya untuk user ini
        $lastSemester = (int) $user->projects()->max('semester'); // null -> 0
        $nextSemester = $lastSemester ? $lastSemester + 1 : 1;

        if ($nextSemester > 8) {
            return back()->withErrors([
                'semester' => 'Semua semester (1–8) sudah terisi. Tidak bisa menambahkan project baru.',
            ])->withInput();
        }

        // Cek apakah user sudah memiliki Anonim sebelumnya
        $existingAnonim = \App\Models\Project::where('user_id', $user->id)
            ->whereNotNull('anonim_name')
            ->orderBy('semester')
            ->value('anonim_name');

        // ------------------ Validasi ------------------
        // Base rules
        $rules = [
            // ----- Basic Info -----
            'title'          => ['required','string','max:255'],
            'category'       => ['nullable','string','max:255'],
            'course'         => ['nullable','string','max:255'],
            'client'         => ['nullable','string','max:255'],
            'project_date'   => ['nullable','date'],
            'design_brief'   => ['nullable','string'],
            'design_process' => ['nullable','string'],
            'spec_material'  => ['nullable','string','max:255'],
            'spec_size'      => ['nullable','string','max:255'],

            // ----- Upload Section (tanpa batas ukuran Laravel; tetap dibatasi PHP/server) -----
            'final_product_photos.*'  => ['file','image','mimes:jpg,jpeg,png,webp'],
            'design_process_photos.*' => ['file','image','mimes:jpg,jpeg,png,webp'],
            'testing_photos.*'        => ['file','image','mimes:jpg,jpeg,png,webp'],
            'display_photos.*'        => ['file','image','mimes:jpg,jpeg,png,webp'],
            'poster_images.*'         => ['file','image','mimes:jpg,jpeg,png,webp'],
            'videos.*'                => ['file','mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska'],
            'video_urls.*'            => ['nullable','url'],
        ];

        // Aturan khusus Anonim:
        // - Jika belum ada Anonim DAN ini project pertama (Semester 1) => anonim wajib
        // - Jika user sudah punya Anonim => input anonim (jika diisi) akan diabaikan (tetap pakai existingAnonim)
        if (!$existingAnonim && $nextSemester === 1) {
            $rules['anonim_name'] = ['required','string','max:100'];
        } else {
            $rules['anonim_name'] = ['nullable','string','max:100'];
        }

        $validated = $request->validate($rules);

        // Tentukan nama Anonim yang akan dipakai utk project yang baru
        // - Jika user sudah punya -> pakai itu
        // - Jika belum & ini Smt 1 -> pakai dari input
        $anonimToUse = $existingAnonim ?: ($validated['anonim_name'] ?? null);

        // ------------------ Create Project ------------------
        $project = \App\Models\Project::create([
            'user_id'        => $user->id,
            'anonim_name'    => $anonimToUse,               // <-- simpan Anonim di project
            'title'          => $validated['title'],
            'category'       => $validated['category'] ?? null,
            'course'         => $validated['course'] ?? null,
            'client'         => $validated['client'] ?? null,
            'project_date'   => $validated['project_date'] ?? null,
            'semester'       => $nextSemester,              // set by system
            'design_brief'   => $validated['design_brief'] ?? null,
            'design_process' => $validated['design_process'] ?? null,
            'spec_material'  => $validated['spec_material'] ?? null,
            'spec_size'      => $validated['spec_size'] ?? null,
        ]);

        // ------------------ Uploads ------------------
        // simpan ke disk 'public' => public/storage/...
        $base = "uploads/projects/{$user->id}/{$project->id}/";

        $saveMany = function (string $key) use ($request, $base) {
            if (!$request->hasFile($key)) return [];
            $stored = [];
            foreach ($request->file($key) as $file) {
                $stored[] = $file->store($base.$key, 'public'); // penting: disk 'public'
            }
            return $stored;
        };

        $project->display_photos        = $saveMany('display_photos');
        $project->final_product_photos  = $saveMany('final_product_photos');
        $project->design_process_photos = $saveMany('design_process_photos');
        $project->testing_photos        = $saveMany('testing_photos');
        $project->poster_images         = $saveMany('poster_images');

        $videos = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $v) {
                $videos[] = $v->store($base.'videos', 'public');
            }
        }
        foreach ((array) $request->input('video_urls', []) as $u) {
            if ($u) $videos[] = $u;
        }
        $project->videos = $videos;

        $project->save();

        return redirect()->route('mhs.myworks')
            ->with('success', "Project berhasil ditambahkan ke Semester {$nextSemester}.");
    }


    // ================== (opsional) View/Edit minimal agar ikon hidup ==================
    public function show(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);
        return view('mhs.projectShow', compact('project'));
    }

    public function edit(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);

        $currentAnonim = Auth::user()
            ->projects()
            ->whereNotNull('anonim_name')
            ->orderBy('semester')
            ->value('anonim_name');

        return view('mhs.addProjectMhs', [
            'project' => $project,
            'isEdit' => true,
            'currentAnonim' => $currentAnonim,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'anonim_name'    => ['nullable','string','max:100'],
            'title'          => ['required','string','max:255'],
            'category'       => ['nullable','string','max:255'],
            'course'         => ['nullable','string','max:255'],
            'client'         => ['nullable','string','max:255'],
            'project_date'   => ['nullable','date'],
            'design_brief'   => ['nullable','string'],
            'design_process' => ['nullable','string'],
            'spec_material'  => ['nullable','string','max:255'],
            'spec_size'      => ['nullable','string','max:255'],
            // file opsional saat edit
            'final_product_photos.*'  => ['file','image','mimes:jpg,jpeg,png,webp'],
            'design_process_photos.*' => ['file','image','mimes:jpg,jpeg,png,webp'],
            'testing_photos.*'        => ['file','image','mimes:jpg,jpeg,png,webp'],
            'display_photos.*'        => ['file','image','mimes:jpg,jpeg,png,webp'],
            'poster_images.*'         => ['file','image','mimes:jpg,jpeg,png,webp'],
            'videos.*'                => ['file','mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska'],
            'video_urls.*'            => ['nullable','url'],
        ]);

        $project->fill([
            'title'          => $validated['title'],
            'category'       => $validated['category'] ?? null,
            'course'         => $validated['course'] ?? null,
            'client'         => $validated['client'] ?? null,
            'project_date'   => $validated['project_date'] ?? null,
            'design_brief'   => $validated['design_brief'] ?? null,
            'design_process' => $validated['design_process'] ?? null,
            'spec_material'  => $validated['spec_material'] ?? null,
            'spec_size'      => $validated['spec_size'] ?? null,
        ]);

        // ------- Propagasi perubahan Anonim (jika diisi) -------
        $incomingAnonim = isset($validated['anonim_name'])
            ? trim((string)$validated['anonim_name'])
            : null;

        if ($incomingAnonim !== null && $incomingAnonim !== '') {
            // Set untuk semua project milik user (SATU anonim per mahasiswa)
            Project::where('user_id', $project->user_id)->update(['anonim_name' => $incomingAnonim]);
            // Pastikan instance sekarang sinkron juga (kalau fill belum mengubah)
            $project->anonim_name = $incomingAnonim;
        }
        
        // ==== HAPUS FILE LAMA sesuai hidden input ====
        $toDelete = $request->input('delete_existing', []); // array: key => [paths]
        $groups = ['final_product_photos','design_process_photos','testing_photos','display_photos','poster_images','videos'];

        foreach ($groups as $key) {
            $del = (array)($toDelete[$key] ?? []);
            if (!empty($del)) {
                // filter array di DB
                $current = $project->{$key} ?? [];
                // normalisasi ke array
                $current = is_array($current) ? $current : [];
                // buang yang dipilih
                $remaining = array_values(array_diff($current, $del));
                $project->{$key} = $remaining;

                // hapus file fisik di storage (hanya kalau path lokal)
                foreach ($del as $path) {
                    if ($path && !preg_match('~^https?://~i', $path)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        $base = "uploads/projects/".Auth::id()."/{$project->id}/";
        $appendMany = function (string $key) use ($request, $project, $base) {
            if (!$request->hasFile($key)) return;
            $current = $project->{$key} ?? [];
            foreach ($request->file($key) as $file) {
                $current[] = $file->store($base.$key, 'public');
            }
            $project->{$key} = $current;
        };

        foreach (['final_product_photos','design_process_photos','testing_photos','display_photos','poster_images'] as $k) {
            $appendMany($k);
        }

        $videos = $project->videos ?? [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $v) {
                $videos[] = $v->store($base.'videos', 'public');
            }
        }
        foreach ((array) $request->input('video_urls', []) as $u) {
            if ($u) $videos[] = $u;
        }
        $project->videos = $videos;

        $project->save();

        return redirect()->route('mhs.myworks')->with('success', 'Project diperbarui.');
    }

    public function destroy(Project $project)
    {
        abort_unless($project->user_id === Auth::id(), 403);
        Storage::disk('public')->deleteDirectory("uploads/projects/".Auth::id()."/{$project->id}");
        $project->delete();
        return back()->with('success', 'Project dihapus.');
    }
}

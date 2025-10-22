<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentProfilingController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q'));
        $pageSize = (int) ($request->integer('size') ?: 10);

        $students = User::query()
            ->where('role', 'mahasiswa')
            ->with([
                // ✅ tambahkan 'photo' agar bisa dipakai di listing jika perlu
                'profile:id,user_id,address,email_pribadi,phone,photo',
                'projects:id,user_id,category',
            ])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name_asli', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhereHas('projects', function ($qq) use ($q) {
                            $qq->where('category', 'like', "%{$q}%");
                        });
                });
            })
            ->orderByRaw('COALESCE(nim, id)')
            ->paginate($pageSize)
            ->withQueryString();

        // Tambah categories_text
        $students->getCollection()->transform(function ($user) {
            $categories = $user->projects
                ->pluck('category')
                ->filter()
                ->unique()
                ->values()
                ->implode(', ');
            $user->categories_text = $categories ?: '-';
            return $user;
        });

        return view('dosen.studentProfiling', [
            'students' => $students,
            'q'        => $q,
            'pageSize' => $pageSize,
        ]);
    }

    public function show(User $user)
    {
        abort_unless($user->role === 'mahasiswa', 404);

        $user->load([
            // ✅ tambahkan 'photo' agar bisa dipakai di tampilan
            'profile:id,user_id,address,email_pribadi,phone,photo',
            'projects:id,user_id,title,course,semester,category,display_photos',
        ]);

        // kategori unik → "A, B, C"
        $categoriesText = $user->projects
            ->pluck('category')
            ->filter()
            ->unique()
            ->values()
            ->implode(', ');

        // ✅ siapkan URL foto profil mahasiswa (public/uploads/profiles)
        $avatarUrl = null;
        if ($user->profile && !empty($user->profile->photo)) {
            $avatarUrl = asset('uploads/profiles/' . $user->profile->photo);
        }

        return view('dosen.showProfile', [
            'user'           => $user,
            'profile'        => $user->profile,
            'projects'       => $user->projects,
            'categoriesText' => $categoriesText ?: '-',
            // ✅ kirim ke blade
            'avatarUrl'      => $avatarUrl,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Profile, CampusAct, Skills, School};

class MhsProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('mhs.profileMhs', [
            'user'       => $user,
            'profile'    => $user->profile ?? new Profile(),
            'activities' => $user->campusActs ?? collect(),      // collection
            'skills'     => $user->skillsMhs ?? collect(),       // collection
            'school'     => $user->school ?? new School(),
        ]);
    }

    public function saveProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Validasi field profil + foto (opsional)
        $validated = $request->validate([
            'phone'          => ['nullable','string','max:30'],
            'address'        => ['nullable','string','max:255'],
            'email_pribadi'  => ['nullable','email','max:255'],
            'motivation'     => ['nullable','string','max:2000'],
            'tags'           => ['nullable','array'],
            'tags.*'         => ['string','max:30'],
            'photo'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'], // 2MB
        ]);

        // Ambil/buat profile milik user
        /** @var \App\Models\Profile $profile */
        $profile = \App\Models\Profile::firstOrCreate(['user_id' => $user->id]);

        // Isi data non-file
        $profile->fill([
            'phone'          => $validated['phone']         ?? $profile->phone,
            'address'        => $validated['address']       ?? $profile->address,
            'email_pribadi'  => $validated['email_pribadi'] ?? $profile->email_pribadi,
            'motivation'     => $validated['motivation']    ?? $profile->motivation,
            'tags'           => $validated['tags']          ?? $profile->tags,
        ]);

        // Handle Upload Foto -> public/uploads/profiles
        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/profiles');
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }

            // Hapus file lama jika ada
            if (!empty($profile->getOriginal('photo'))) {
                $old = public_path('uploads/profiles/' . $profile->getOriginal('photo'));
                if (file_exists($old)) {
                    @unlink($old);
                }
            }

            $file = $request->file('photo');
            $ext  = $file->getClientOriginalExtension();
            $name = 'mhs_'.$user->id.'_'.\Illuminate\Support\Str::uuid().'.'.$ext;

            $file->move($dir, $name);
            $profile->photo = $name;
        }

        $profile->save();

        return back()->with('success', 'Profile saved.');
    }



    public function saveActivities(Request $request)
    {
        $user = Auth::user();
        $acts = array_filter($request->input('activities', []));

        // reset & simpan ulang sederhana
        $user->campusActs()->delete();
        foreach ($acts as $a) {
            CampusAct::create([
                'user_id' => $user->id,
                'activity' => trim($a),
            ]);
        }
        return back()->with('success', 'Activities saved.');
    }

    public function saveSkills(Request $request)
    {
        $user = Auth::user();
        $skills = array_filter($request->input('skills', []));

        $user->skillsMhs()->delete();
        foreach ($skills as $s) {
            Skills::create([
                'user_id' => $user->id,
                'skill'   => trim($s),
            ]);
        }
        return back()->with('success', 'Skills saved.');
    }

    public function saveSchool(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'school_origin' => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'regency'       => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'level'         => 'nullable|in:SMA,SMK',
        ]);

        School::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success', 'School saved.');
    }
}

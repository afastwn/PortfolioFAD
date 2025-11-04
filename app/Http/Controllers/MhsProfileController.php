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

        // Validasi field profil + foto (opsional) + password (opsional)
        $validated = $request->validate([
            'phone'            => ['nullable','string','max:30'],
            'address'          => ['nullable','string','max:255'],
            'email_pribadi'    => ['nullable','email','max:255'],
            'motivation'       => ['nullable','string','max:2000'],
            'tags'             => ['nullable','array'],
            'tags.*'           => ['string','max:30'],
            'photo'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'], // 2MB

            // Current password wajib kalau ingin ganti password dan harus match
            // gunakan rule bawaan Laravel: current_password
            'current_password' => ['nullable','string','required_with:new_password','current_password'],

            // New password opsional, min 6, kombinasi huruf & angka, beda dari current
            'new_password'     => ['nullable','string','min:6','regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/','different:current_password'],
        ], [
            'new_password.min'               => 'Password must be at least 6 characters.',
            'new_password.regex'             => 'Passwords must contain a combination of letters and numbers.',
            'new_password.different'         => 'The new password cannot be the same as the current password.',
            'current_password.required_with' => 'Enter the current password to change it.',
            'current_password.current_password' => 'The current password does not match.',
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
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }

            // Hapus file lama jika ada
            if (!empty($profile->getOriginal('photo'))) {
                $old = public_path('uploads/profiles/' . $profile->getOriginal('photo'));
                if (file_exists($old)) { @unlink($old); }
            }

            $file = $request->file('photo');
            $ext  = $file->getClientOriginalExtension();
            $name = 'mhs_'.$user->id.'_'.\Illuminate\Support\Str::uuid().'.'.$ext;

            $file->move($dir, $name);
            $profile->photo = $name;
        }

        // Simpan perubahan profil
        $profile->save();

        // Update password bila diisi (pada titik ini current_password sudah tervalidasi)
        if ($request->filled('new_password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->input('new_password'));
            $user->save();
        }

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
        $user = \Illuminate\Support\Facades\Auth::user();

        // Validasi
        $validated = $request->validate([
            'school_origin' => ['nullable','string','max:255'],
            'level'         => ['nullable','in:SMA,SMK'],
            'province_id'   => ['required','string','max:3'],
            'regency_id'    => ['nullable','integer','exists:cities,id'],
            'city_id'       => ['nullable','integer','exists:cities,id'],
        ]);

        // Ambil nilai secara aman (bisa null)
        $cityId    = $request->input('city_id');    // null jika tidak dikirim
        $regencyId = $request->input('regency_id'); // null jika tidak dikirim

        // Wajib salah satu
        if (!$cityId && !$regencyId) {
            return back()->withErrors([
                'city_id' => 'Pilih City atau Regency.'
            ])->withInput();
        }

        // City prioritas; kalau tidak ada, pakai regency
        $chosenId = $cityId ?? $regencyId;
        $chosen   = \App\Models\City::find($chosenId);
        if (!$chosen) {
            return back()->withErrors([
                'city_id' => 'Lokasi tidak valid.'
            ])->withInput();
        }

        // Nama provinsi konsisten dari referensi
        $provinceName = $chosen->province;

        // Set salah satu & kosongkan yang lain (hindari “nyangkut”)
        $regName  = $chosen->type === 'KAB'  ? $chosen->name : null;
        $cityName = $chosen->type === 'KOTA' ? $chosen->name : null;

        \App\Models\School::updateOrCreate(
            ['user_id' => $user->id],
            [
                'school_origin' => $validated['school_origin'] ?? null,
                'level'         => $validated['level'] ?? null,
                'province'      => $provinceName,
                'regency'       => $regName,   // terisi hanya jika KAB
                'city'          => $cityName,  // terisi hanya jika KOTA
                'city_id'       => $chosen->id,
            ]
        );

        return back()->with('success', 'School saved.');
    }



}

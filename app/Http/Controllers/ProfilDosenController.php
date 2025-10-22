<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfilDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilDosenController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // buat profil kosong jika belum ada
        $profil = $user->profilDosen()->firstOrCreate(['user_id' => $user->id]);

        return view('dosen.profileDsn', [
            'user'   => $user,   // berisi name_asli, nip, nidn
            'profil' => $profil,
        ]);
    }

    public function update(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // validasi utk kolom di tabel users
        $dataUser = $request->validate([
            'name_asli' => ['nullable','string','max:100'],
            'nip'       => ['nullable','string','max:50'],
            'nidn'      => ['nullable','string','max:50'],
        ]);

        // validasi utk kolom di tabel profil_dosen
        $dataProfil = $request->validate([
            'department'       => ['nullable','string','max:255'],
            'academic_advisor' => ['nullable','string','max:255'],
            'personal_email'   => ['nullable','email','max:255'],
            'phone_number'     => ['nullable','string','max:30'],
            'photo'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'], // tambahkan
        ]);

        // simpan users
        $user->fill(array_filter($dataUser, fn($v) => !is_null($v)))->save();

        // ambil/siapkan profil_dosen
        /** @var \App\Models\ProfilDosen $profil */
        $profil = $user->profilDosen()->firstOrCreate(['user_id' => $user->id]);

        // isi data non-file
        $profil->fill([
            'department'       => $dataProfil['department']       ?? $profil->department,
            'academic_advisor' => $dataProfil['academic_advisor'] ?? $profil->academic_advisor,
            'personal_email'   => $dataProfil['personal_email']   ?? $profil->personal_email,
            'phone_number'     => $dataProfil['phone_number']     ?? $profil->phone_number,
        ]);

        // Handle upload foto (pakai kolom avatar_path)
        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/profiles');
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }

            // hapus lama jika ada
            if (!empty($profil->getOriginal('avatar_path'))) {
                $old = public_path('uploads/profiles/' . $profil->getOriginal('avatar_path'));
                if (file_exists($old)) {
                    @unlink($old);
                }
            }

            $file = $request->file('photo');
            $ext  = $file->getClientOriginalExtension();
            $name = 'dsn_'.$user->id.'_'.\Illuminate\Support\Str::uuid().'.'.$ext;

            $file->move($dir, $name);
            $profil->avatar_path = $name;
        }

        $profil->save();

        return redirect()->route('dosen.profile.show')->with('success', 'Profil dosen diperbarui.');
    }


}

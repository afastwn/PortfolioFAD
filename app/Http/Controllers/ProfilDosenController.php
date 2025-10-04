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
        $user = Auth::user();

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
        ]);

        // simpan users
        $user->fill(array_filter($dataUser, fn($v) => !is_null($v)))->save();

        // simpan profil_dosen
        $user->profilDosen()->updateOrCreate(
            ['user_id' => $user->id],
            $dataProfil
        );

        return redirect()->route('dosen.profile.show')->with('success', 'Profil dosen diperbarui.');
    }

}

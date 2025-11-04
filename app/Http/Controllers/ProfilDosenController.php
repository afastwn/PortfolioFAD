<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfilDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilDosenController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // buat profil kosong jika belum ada
        $profil = $user->profilDosen()->firstOrCreate(['user_id' => $user->id]);

        return view('dosen.profileDsn', [
            'user'   => $user,   // berisi name_asli, nik
            'profil' => $profil,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // validasi user fields
        $dataUser = $request->validate([
            'name_asli' => ['nullable','string','max:100'],
            'nik'       => ['nullable','string','max:50'],
        ]);

        // validasi profil fields
        $dataProfil = $request->validate([
            'department'       => ['nullable','string','max:255'],
            'academic_advisor' => ['nullable','string','max:255'],
            'personal_email'   => ['nullable','email','max:255'],
            'phone_number'     => ['nullable','string','max:30'],
            'photo'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],

            // === password (opsional) ===
            'current_password' => ['nullable','string','required_with:new_password','current_password'],
            'new_password'     => ['nullable','string','min:6','regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/','different:current_password'],
        ], [
            'new_password.min' => 'Password minimal 6 karakter.',
            'new_password.regex' => 'Password harus mengandung kombinasi huruf dan angka.',
            'new_password.different' => 'Password baru tidak boleh sama dengan current password.',
            'current_password.required_with' => 'Masukkan current password untuk mengganti password.',
            'current_password.current_password' => 'Current password tidak sesuai.',
        ]);

        // simpan user
        $user->fill(array_filter($dataUser, fn($v) => !is_null($v)))->save();

        // ambil profil dosen
        $profil = $user->profilDosen()->firstOrCreate(['user_id' => $user->id]);

        $dept = $request->input('department');
        if (!is_null($dept)) {
            $dept = trim($dept);
            $dept = match ($dept) {
                'Desain Produk', 'Product Design', 'product_design' => 'Product Design',
                'Arsitektur', 'Architecture', 'architecture'        => 'Architecture',
                default => $dept,
            };
        }

       $profil->fill([
            'department'       => $dept ?? $profil->department,
            'academic_advisor' => $dataProfil['academic_advisor'] ?? $profil->academic_advisor,
            'personal_email'   => $dataProfil['personal_email']   ?? $profil->personal_email,
            'phone_number'     => $dataProfil['phone_number']     ?? $profil->phone_number,
        ]);

        // upload foto
        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/profiles');
            if (!is_dir($dir)) @mkdir($dir, 0775, true);

            if (!empty($profil->getOriginal('avatar_path'))) {
                $old = public_path('uploads/profiles/' . $profil->getOriginal('avatar_path'));
                if (file_exists($old)) @unlink($old);
            }

            $file = $request->file('photo');
            $ext  = $file->getClientOriginalExtension();
            $name = 'dsn_'.$user->id.'_'.\Illuminate\Support\Str::uuid().'.'.$ext;
            $file->move($dir, $name);
            $profil->avatar_path = $name;
        }

        $profil->save();

        // === Ganti password bila valid ===
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
        }

        return redirect()->route('dosen.profile.show')->with('success', 'Profil dosen diperbarui.');
    }



}

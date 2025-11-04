<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 


class AdminController extends Controller
{
    public function storeStudent(Request $request)
    {
        $request->validate([
            'nim'       => 'required|numeric|unique:users,nim',
            'name'      => 'required|string|max:100',
            'password'  => 'required|string|min:6',
        ]);

        User::create([
            'nim'       => $request->nim,
            'nik'       => null,
            'name_asli' => $request->name,
            'username'  => $request->nim, // boleh juga dibuat berbeda
            'email'     => $request->nim . '@ukdw.ac.id',
            'role'      => 'mahasiswa',
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('admin.addStudents')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function storeDosen(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            // NIP: huruf & angka saja, wajib diisi, unik
            'nik'      => ['required','string','max:50','unique:users,nik','regex:/^[A-Za-z0-9]+$/'],
            'password' => ['required','string','min:6'],
            'role'     => ['required','in:dosen,kaprodi'],
        ], [
            'nik.required'    => 'NIK must be filled in.',
            'nik.regex'       => 'NIK may only contain letters and numbers.',
        ]);

        User::create([
            'nim'       => null,
            'nik'       => $request->nik,
            'name_asli' => $request->name,
            'username'  => null,                   // sesuai permintaan: null dulu
            'email'     => null,                   // aman: null dulu (kolom harus nullable)
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.addDosen')
            ->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function destroyUser(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak dapat menghapus akunmu sendiri.');
        }

        // Batasi hanya admin yang bisa hapus siapa pun
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat menghapus akun.');
        }

        // Hapus user (opsional: hapus relasi juga di sini)
        $user->delete();

        $roleName = ucfirst($user->role); // Dosen / Mahasiswa / dst
        return back()->with('success', "$roleName berhasil dihapus.");
    }
}

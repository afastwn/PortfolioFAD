<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;     // <- WAJIB


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
            'nip'       => null,
            'nidn'      => null,
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
            'nip'      => ['required','string','max:50','unique:users,nip','regex:/^[A-Za-z0-9]+$/'],
            // NIDN: angka saja, wajib diisi, unik (umumnya 10 digit)
            'nidn'     => ['required','digits:10','unique:users,nidn'],
            'password' => ['required','string','min:6'],
        ], [
            'nip.required'    => 'NIP wajib diisi.',
            'nip.regex'       => 'NIP hanya boleh berisi huruf dan angka.',
            'nidn.required'   => 'NIDN wajib diisi.',
            'nidn.digits'     => 'NIDN harus 10 digit angka.',
        ]);

        User::create([
            'nim'       => null,
            'nip'       => $request->nip,
            'nidn'      => $request->nidn,
            'name_asli' => $request->name,
            'username'  => null,                   // sesuai permintaan: null dulu
            'email'     => null,                   // aman: null dulu (kolom harus nullable)
            'role'      => 'dosen',
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

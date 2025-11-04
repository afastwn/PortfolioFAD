<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Project;

class LoginController extends Controller
{
    public function index()
    {
        // Ambil maksimal 7 project terbaru (bisa sesuaikan filter publik jika ada)
        $projects = Project::query()
            // ->where('is_public', true)     // aktifkan jika ada kolom visibilitas
            // ->where('status', 'published') // aktifkan jika pakai status publikasi
            ->with(['currentViewerInteraction']) // penting agar status like publik terbaca (via cookie anon)
            ->select(['id', 'anonim_name', 'title', 'display_photos'])
            ->latest('updated_at')
            ->take(7)
            ->get();

        // Kirim data project ke view login.blade.php
        return view('login', compact('projects'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = trim($request->input('login')); // jangan lowercase, biar NIP huruf besar tetap bisa
        $credentials = [];

        /**
         * Login rules:
         * 1. Jika semua angka -> mahasiswa (NIM)
         * 2. Jika diawali huruf 'ADM' (atau username cocok di DB) -> admin
         * 3. Jika campuran huruf/angka tanpa simbol -> dosen (NIP)
         */

        if (preg_match('/^\d+$/', $login)) {
            // Mahasiswa (NIM)
            $credentials = [
                'email'    => strtolower($login) . '@ukdw.ac.id',
                'password' => $request->password,
            ];
        } elseif ($this->isAdminUser($login)) {
            // Admin (username)
            $credentials = [
                'username' => $login,
                'password' => $request->password,
            ];
        } else {
            // Dosen (NIK)
            $credentials = [
                'nik'      => $login,
                'password' => $request->password,
            ];
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'NIM/NIK/Username atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        return match (auth()->user()->role) {
            'admin'     => redirect()->route('admin.addStudents'),
            'dosen'     => redirect()->route('dosen.dashboard'),
            'kaprodi'     => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mhs.dashboard'),
            default     => redirect('/'),
        };
    }

    private function isAdminUser(string $login): bool
    {
        // Bisa pakai pola tertentu, atau cek langsung ke DB
        return \App\Models\User::where('username', $login)
            ->where('role', 'admin')
            ->exists();
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

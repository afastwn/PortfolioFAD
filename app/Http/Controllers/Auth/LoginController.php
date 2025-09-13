<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = trim(strtolower($request->input('login')));

        $credentials = [];

        // Jika input hanya angka → anggap mahasiswa (nim → email)
        if (preg_match('/^\d+$/', $login)) {
            $credentials = [
                'email'    => $login.'@ukdw.ac.id',
                'password' => $request->password,
            ];
        } else {
            // Anggap dosen → pakai username
            $credentials = [
                'username' => $login,
                'password' => $request->password,
            ];
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'NIM/Username atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        // redirect per role
        return match (auth()->user()->role) {
            'dosen'     => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mhs.dashboard'),
            default     => redirect('/'),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

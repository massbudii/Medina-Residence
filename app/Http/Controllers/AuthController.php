<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:64',
            'password' => 'required|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        // Email tidak ditemukan
        if (!$user) {
            return back()
                ->withInput()
                ->with('failed', 'Email tidak terdaftar');
        }

        // Password salah
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput()
                ->with('failed', 'Password yang Anda masukkan salah');
        }

        // Akun nonaktif
        if ($user->status != 'aktif') {
            return back()
                ->withInput()
                ->with('failed', 'Akun Anda telah dinonaktifkan');
        }

        Auth::login($user);

        return redirect('/dashboard');


    }


    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}

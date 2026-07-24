<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:64',
            'password' => ['required', 'string', 'min:6', 'regex:/^[A-Z](?=.*[0-9]).+$/'],
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.regex' => 'Password harus diawali huruf besar (kapital) dan mengandung kombinasi huruf serta angka (contoh: Admin123)',
        ]);

        // Key Throttle berdasarkan Email & IP Address
        $throttleKey = Str::transliterate(strtolower($request->input('email')) . '|' . $request->ip());

        // 1. Cek apakah pengguna sudah terblokir karena 3 kali gagal
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput()
                ->with('lockout_seconds', $seconds)
                ->with('failed', "Terlalu banyak percobaan login yang gagal. Silakan tunggu {$seconds} detik lagi.");
        }

        // 2. Pencarian user dengan email ter-enkripsi
        $user = User::all()->first(function ($u) use ($request) {
            return strtolower($u->email) === strtolower($request->email);
        });

        // Email tidak ditemukan
        if (!$user) {
            RateLimiter::hit($throttleKey, 30);
            $attemptsLeft = max(0, 3 - RateLimiter::attempts($throttleKey));

            if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                return back()
                    ->withInput()
                    ->with('lockout_seconds', $seconds)
                    ->with('failed', "Terlalu banyak percobaan login yang gagal. Silakan tunggu {$seconds} detik lagi.");
            }

            return back()
                ->withInput()
                ->with('failed', "Email tidak terdaftar. Sisa kesempatan login Anda: {$attemptsLeft} kali lagi.");
        }

        // Password salah
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 30);
            $attemptsLeft = max(0, 3 - RateLimiter::attempts($throttleKey));

            if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                return back()
                    ->withInput()
                    ->with('lockout_seconds', $seconds)
                    ->with('failed', "Terlalu banyak percobaan login yang gagal. Silakan tunggu {$seconds} detik lagi.");
            }

            return back()
                ->withInput()
                ->with('failed', "Password yang Anda masukkan salah. Sisa kesempatan login Anda: {$attemptsLeft} kali lagi.");
        }

        // Akun nonaktif
        if ($user->status != 'aktif') {
            RateLimiter::hit($throttleKey, 30);
            $attemptsLeft = max(0, 3 - RateLimiter::attempts($throttleKey));

            if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                return back()
                    ->withInput()
                    ->with('lockout_seconds', $seconds)
                    ->with('failed', "Terlalu banyak percobaan login yang gagal. Silakan tunggu {$seconds} detik lagi.");
            }

            return back()
                ->withInput()
                ->with('failed', "Akun Anda telah dinonaktifkan. Sisa kesempatan login Anda: {$attemptsLeft} kali lagi.");
        }

        // 3. Login Berhasil -> Reset hit percobaan login & langsung Authenticate
        RateLimiter::clear($throttleKey);

        Auth::login($user);

        $message = match ($user->role) {
            'admin' => "Selamat datang, {$user->nama}. Anda berhasil login sebagai Admin.",
            'mandor' => "Selamat datang, {$user->nama}. Anda berhasil login sebagai Mandor.",
            default => "Selamat datang, {$user->nama}. Anda berhasil login.",
        };

        // Guard Profil: Jika foto profil belum ada/lengkap, wajib isi profil dulu
        if (empty($user->foto)) {
            return redirect()->route('profile.index')
                ->with('wajib_isi_profil', true)
                ->with('warning', 'Wajib melengkapi profil dan foto pengguna terlebih dahulu.');
        }

        return redirect('/dashboard')
            ->with('login_success', $message);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}

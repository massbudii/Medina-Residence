<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil formal pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Memperbarui data profil & upload foto profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => ['nullable', 'string', 'min:6', 'regex:/^[A-Z](?=.*[0-9]).+$/'],
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'foto.image' => 'File foto harus berupa gambar',
            'foto.mimes' => 'Format foto yang diperbolehkan: jpeg, png, jpg, gif',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'password.min' => 'Password minimal 6 karakter',
            'password.regex' => 'Password harus diawali huruf besar (kapital) dan mengandung kombinasi huruf serta angka (contoh: Admin123)',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ];

        // Jika password diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Upload foto profil jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Buat direktori jika belum ada
            $destinationPath = public_path('uploads/profile');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Hapus foto lama jika bukan foto default
            if ($user->foto && File::exists(public_path($user->foto))) {
                File::delete(public_path($user->foto));
            }

            $file->move($destinationPath, $filename);
            $data['foto'] = 'uploads/profile/' . $filename;
        }

        $user->update($data);

        return redirect()->route('profile.index')->with('success', 'Profil pengguna berhasil diperbarui!');
    }
}

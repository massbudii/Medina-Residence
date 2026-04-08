<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'role.required' => 'Role wajib diisi',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'aktif';
        User::create($validated);
        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id == 1) {
            return back()->with('error', 'Admin utama tidak bisa diedit');
        }

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'role.required' => 'Role wajib dipilih',
        ]);

        $data = $request->only(['nama', 'email', 'role']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diupdate');
    }
    // nonaktifkan user

    public function nonaktif($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::id()) {
            return back()->with('error', 'Tidak bisa nonaktifkan diri sendiri');
        }


        if ($user->id == 1) {
            return back()->with('error', 'admin utama tidak bisa di nonaktifkan');
        }

        $adminAktif = User::where('role', 'admin')
            ->where('status', 'aktif')
            ->count();

        if ($user->role == 'admin' && $adminAktif <= 1) {
            return back()->with('error', 'Minimal 1 admin harus aktif');
        }

        $user->update([
            'status' => 'Nonaktif',
        ]);

        return back()->with('success', 'User berhasil di nonaktifkan');
    }

    // aktifkan user

    public function aktif($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 'aktif'
        ]);

        return back()->with('success', 'User berhasil diaktifkan');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() != 1) {
            return back()->with('error', 'Hanya admin utama yang boleh menghapus user');
        }

        if ($user->id == Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}

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
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'aktif'
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // data utama
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // jika pw diisi update kalau engga kosonh
        if($request->password) {
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
    }
}

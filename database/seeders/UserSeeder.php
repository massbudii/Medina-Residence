<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 
        User::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'status' => 'aktif'
        ]);

        //  Mandor 1
        User::create([
            'nama' => 'Mandor 1',
            'email' => 'mandor1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mandor',
            'status' => 'aktif'
        ]);

        //  Mandor 2
        User::create([
            'nama' => 'Mandor 2',
            'email' => 'mandor2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mandor',
            'status' => 'aktif'
        ]);
    }
}

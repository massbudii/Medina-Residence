<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        // Mandor 1
        User::updateOrCreate(
            ['email' => 'mandor1@gmail.com'],
            [
                'nama' => 'Mandor 1',
                'password' => Hash::make('password'),
                'role' => 'mandor',
                'status' => 'aktif',
            ]
        );

        // Mandor 2
        User::updateOrCreate(
            ['email' => 'mandor2@gmail.com'],
            [
                'nama' => 'Mandor 2',
                'password' => Hash::make('password'),
                'role' => 'mandor',
                'status' => 'aktif',
            ]
        );
    }
}

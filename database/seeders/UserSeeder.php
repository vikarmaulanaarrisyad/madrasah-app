<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data user untuk setiap role
        $users = [
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Guru User',
                'username' => 'guru',
                'email' => 'guru@example.com',
                'password' => Hash::make('password'),
                'role' => 'Guru',
            ],
            [
                'name' => 'Kepala Madrasah',
                'username' => 'kepala',
                'email' => 'kepala@example.com',
                'password' => Hash::make('password'),
                'role' => 'Kepala',
            ],
        ];

        // Membuat user dan menetapkan role
        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'password' => $userData['password'],
                ]
            );

            $user->assignRole($userData['role']);
        }

        $this->command->info('Users berhasil ditambahkan!');
    }
}

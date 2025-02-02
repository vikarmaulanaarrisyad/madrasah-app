<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Role();
        $admin->name = 'Admin';
        $admin->save();

        $guru = new Role;
        $guru->name = 'Guru';
        $guru->save();

        $kepala = new Role;
        $kepala->name = 'Kepala';
        $kepala->save();
    }
}

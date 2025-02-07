<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'P5RA', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Pendidikan Pancasila', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Bahasa Indonesia', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Matematika', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Ilmu Pengetahuan Alam Dan Sosial', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Bahasa Arab', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Bahasa Inggris', 'group' => 'A', 'curiculum_id' => 2],

            ['name' => 'Seni Budaya dan Prakarya (SBdP)', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Muatan Lokal', 'group' => 'B', 'curiculum_id' => 2],
            ['name' => 'Bahasa Jawa', 'group' => 'B', 'curiculum_id' => 2],

            ['name' => 'Al-Qur\'an Hadits', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Aqidah Akhlak', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Fiqih', 'group' => 'A', 'curiculum_id' => 2],
            ['name' => 'Sejarah Kebudayaan Islam (SKI)', 'group' => 'A', 'curiculum_id' => 2],
        ];

        DB::table('subjects')->insert($subjects);
    }
}

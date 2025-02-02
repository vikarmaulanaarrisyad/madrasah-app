<?php

namespace Database\Seeders;

use App\Models\Curiculum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Kurikulum 2013'
            ],
            [
                'name' => 'Kurikulum Merdeka'
            ],
        ];

        foreach ($data as $value) {
            Curiculum::create($value);
        }
    }
}

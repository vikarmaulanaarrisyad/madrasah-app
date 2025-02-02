<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Kelas 1',
                'level' => 1
            ],
            [
                'name' => 'Kelas 2',
                'level' => 2
            ],
            [
                'name' => 'Kelas 3',
                'level' => 3
            ],
            [
                'name' => 'Kelas 4',
                'level' => 4
            ],
            [
                'name' => 'Kelas 5',
                'level' => 5
            ],
            [
                'name' => 'Kelas 6',
                'level' => 6
            ],
        ];

        foreach ($data as $value) {
            Level::create($value);
        }
    }
}

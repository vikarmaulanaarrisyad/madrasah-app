<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Laki-laki',
            ],
            [
                'name' => 'Perempuan',
            ],
        ];

        foreach ($data as $value) {
            Gender::create($value);
        }
    }
}

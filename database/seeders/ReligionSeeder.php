<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Islam'
            ],
            [
                'name' => 'Hindu'
            ],
            [
                'name' => 'Katolik'
            ],
        ];

        foreach ($data as $value) {
            Religion::create($value);
        }
    }
}

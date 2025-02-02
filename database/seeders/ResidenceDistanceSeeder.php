<?php

namespace Database\Seeders;

use App\Models\ResidenceDistance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidenceDistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Kurang dari 5 Km'
            ],
            [
                'name' => 'Antara 5 - 10 Km'
            ],
            [
                'name' => 'Antara 11 - 20 Km'
            ],
            [
                'name' => 'Antara 21 - 30 Km'
            ],
            [
                'name' => 'Lebih dari 30 Km'
            ],
        ];

        foreach ($data as $value) {
            ResidenceDistance::create($value);
        }
    }
}

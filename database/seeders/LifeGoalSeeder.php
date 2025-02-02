<?php

namespace Database\Seeders;

use App\Models\LifeGoal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LifeGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'PNS'
            ],
            [
                'name' => 'TNI/POLRI'
            ],
            [
                'name' => 'Guru/Dosen'
            ],
            [
                'name' => 'Dokter'
            ],
            [
                'name' => 'Politikus'
            ],
            [
                'name' => 'Wiraswasta'
            ],
            [
                'name' => 'Seniman/Artis'
            ],
            [
                'name' => 'Ilmuwan'
            ],
            [
                'name' => 'Agamawan'
            ],
            [
                'name' => 'Lainnya'
            ],
        ];

        foreach ($data as $value) {
            LifeGoal::create($value);
        }
    }
}

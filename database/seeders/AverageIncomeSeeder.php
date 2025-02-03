<?php

namespace Database\Seeders;

use App\Models\AverageIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AverageIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Kurang dari 500.000'
            ],
            [
                'name' => '500.000 - 1.000.000'
            ],
            [
                'name' => '1.000.000 - 2.000.000'
            ],
            [
                'name' => '2.000.000 - 3.000.000'
            ],
            [
                'name' => '3.000.000 - 4.000.000'
            ],
            [
                'name' => 'Lebih dari 5.000.000'
            ],
            [
                'name' => 'Tidak ada'
            ],
        ];

        foreach ($data as $value) {
            AverageIncome::create($value);
        }
    }
}

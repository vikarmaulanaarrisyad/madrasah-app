<?php

namespace Database\Seeders;

use App\Models\ResidenceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidenceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Tinggal dengan Ayah Kandung'
            ],
            [
                'name' => 'Tinggal dengan Ibu Kandung'
            ],
            [
                'name' => 'Tinggal dengan Wali'
            ],
            [
                'name' => 'Ikut Saudara/Kerabat'
            ],
            [
                'name' => 'Lainnya'
            ],
        ];

        foreach ($data as $value) {
            ResidenceStatus::create($value);
        }
    }
}

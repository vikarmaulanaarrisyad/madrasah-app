<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'SD/Sederajat',
            ],
            [
                'name' => 'SMP/Sederajat',
            ],
            [
                'name' => 'SMA/Sederajat',
            ],
            [
                'name' => 'D1',
            ],
            [
                'name' => 'D2',
            ],
            [
                'name' => 'D3',
            ],
            [
                'name' => 'D4/S1',
            ],
            [
                'name' => 'S2',
            ],
            [
                'name' => 'S3',
            ],
            [
                'name' => 'Tidak Bersekolah',
            ],
            [
                'name' => 'Lainnya',
            ],
        ];

        foreach ($data as $value) {
            Education::create($value);
        }
    }
}

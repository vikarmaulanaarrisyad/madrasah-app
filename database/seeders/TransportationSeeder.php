<?php

namespace Database\Seeders;

use App\Models\Transportation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Jalan Kai'
            ],
            [
                'name' => 'Sepeda'
            ],
            [
                'name' => 'Sepeda Motor'
            ],
            [
                'name' => 'Antar Jemput Sekolah'
            ],
            [
                'name' => 'Lainnya'
            ],
        ];

        foreach ($data as $value) {
            Transportation::create($value);
        }
    }
}

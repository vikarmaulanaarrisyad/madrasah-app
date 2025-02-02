<?php

namespace Database\Seeders;

use App\Models\LifeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LifeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Masih Hidup'
            ],
            [
                'name' => 'Sudah Meninggal'
            ],
            [
                'name' => 'Tidak Diketahui'
            ],
        ];

        foreach ($data as $value) {
            LifeStatus::create($value);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Tidak bekerja'
            ],
            [
                'name' => 'Pensiunan'
            ],
            [
                'name' => 'PNS'
            ],
            [
                'name' => 'TNI/Polisi'
            ],
            [
                'name' => 'Guru/Dosen'
            ],
            [
                'name' => 'Pegawai Swasta'
            ],
            [
                'name' => 'Wiraswasta'
            ],
            [
                'name' => 'Dokter/Bidan'
            ],
            [
                'name' => 'Pedagang'
            ],
            [
                'name' => 'Petani/Peternak'
            ],
            [
                'name' => 'Nelayan'
            ],
            [
                'name' => 'Buruh (Tani/Pabrik/Bangunan)'
            ],
            [
                'name' => 'Sopir'
            ],
            [
                'name' => 'Lainnya'
            ],
        ];

        foreach ($data as $value) {
            Job::create($value);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Olahraga',
            ],
            [
                'name' => 'Kesenian',
            ],
            [
                'name' => 'Membaca',
            ],
            [
                'name' => 'Menulis',
            ],
            [
                'name' => 'Jalan-jalan',
            ],
            [
                'name' => 'Lainnya',
            ],
        ];

        foreach ($data as $value) {
            Hobby::create($value);
        }
    }
}

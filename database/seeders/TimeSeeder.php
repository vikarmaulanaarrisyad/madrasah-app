<?php

namespace Database\Seeders;

use App\Models\Time;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '1-10 menit'
            ],
            [
                'name' => '10-19 menit'
            ],
            [
                'name' => '20-29 menit'
            ],
            [
                'name' => '30-39 menit'
            ],
            [
                'name' => '1-2 jam'
            ],
        ];

        foreach ($data as $value) {
            Time::create($value);
        }
    }
}

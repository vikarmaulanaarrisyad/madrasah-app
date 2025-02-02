<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => '2025/2026',
            'year' => '2025/2026',
            'semester' => 'Ganjil',
            'is_active' => 0,
        ];

        AcademicYear::create($data);
    }
}

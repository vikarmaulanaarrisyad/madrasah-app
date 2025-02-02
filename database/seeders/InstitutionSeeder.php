<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'institution_head' => 'Kepala Madrasah',
            'institution_status' => 'swasta',
            'npsn' => '6071231',
            'nsm' => '1234556'
        ];

        Institution::create($data);
    }
}

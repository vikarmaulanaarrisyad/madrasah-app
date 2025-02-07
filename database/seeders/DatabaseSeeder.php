<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            InstitutionSeeder::class,
            AcademicYearSeeder::class,
            LevelSeeder::class,
            GenderSeeder::class,
            ReligionSeeder::class,
            LifeGoalSeeder::class,
            HobbySeeder::class,
            ResidenceDistanceSeeder::class,
            ResidenceStatusSeeder::class,
            TransportationSeeder::class,
            TimeSeeder::class,
            JobSeeder::class,
            EducationSeeder::class,
            AverageIncomeSeeder::class,
            LifeStatusSeeder::class,
            CuriculumSeeder::class,
            SubjectSeeder::class,
        ]);
    }
}

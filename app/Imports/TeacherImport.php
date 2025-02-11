<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Gender;
use App\Models\Religion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeacherImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            // Bersihkan nama kolom dari spasi yang tidak perlu
            $row = array_map('trim', $row);
            // Cek apakah User sudah ada berdasarkan email
            $user = User::firstOrCreate([
                'email' => $row['email'] // Pastikan menggunakan nama kolom 'email' sesuai dengan data yang ada
            ], [
                'name' => $row['nama_lengkap'],
                'email' => $row['email'],
                'username' => $row['username'],
                'password' => Hash::make('password123'), // Set default password
            ]);

            $user->assignRole('Guru');

            // Cek apakah Gender sudah ada berdasarkan nama
            $gender = Gender::firstOrCreate(['name' => $row['jenis_kelamin']]);

            // Cek apakah Religion sudah ada berdasarkan nama
            $religion = Religion::firstOrCreate(['name' => $row['agama']]);

            // Cek apakah tanggal lahir dalam format Excel serial
            $birthDate = $this->convertExcelDateToDate($row['tanggal_lahir']);

            // Cek apakah Teacher sudah ada berdasarkan user_id
            $teacher = Teacher::firstOrCreate([
                'user_id' => $user->id
            ], [
                'full_name'    => $row['nama_lengkap'],
                'brith_place'  => $row['tempat_lahir'],
                'birth_date'   => $birthDate,  // Menggunakan tanggal yang sudah dikonversi
                'm_gender_id'  => $gender->id, // Menggunakan ID dari Gender
                'm_religion_id' => $religion->id, // Menggunakan ID dari Religion
                'rt'           => $row['rt'],
                'rw'           => $row['rw'],
                'address'      => $row['alamat'],
                'tmt_teacher'  => $row['tmt_guru'],
                'tmt_employe'  => $row['tmt_pegawai'],
            ]);

            DB::commit(); // Commit jika berhasil
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada error
            throw $e;  // Lemparkan error kembali untuk ditangani
        }

        return $user;
    }

    // Fungsi untuk mengonversi Excel date serial menjadi DateTime
    private function convertExcelDateToDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Mengonversi Excel date serial menjadi objek DateTime
            $date = Date::excelToDateTimeObject($excelDate);
            return $date->format('Y-m-d'); // Format tanggal yang diinginkan
        }

        return $excelDate; // Jika bukan angka, anggap sudah dalam format yang benar
    }
}

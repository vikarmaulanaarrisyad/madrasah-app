<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnFormatting
{
    private $index = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::with([
            'gender',
            'religion',
            'parent',
            'hobby',
            'lifeGoal',
            'residenceDistance',
            'time',
            'transportation',
            'learningActivities'
        ])->orderBy('full_name', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NISN',
            'NIS',
            'NAMA LENGKAP',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'AGAMA',
            'ALAMAT',
            'NAMA AYAH',
            'TEMPAT LAHIR AYAH',
            'TANGGAL LAHIR AYAH',
            'ALAMAT AYAH',
            'NAMA IBU',
            'TEMPAT LAHIR IBU',
            'TANGGAL LAHIR IBU',
            'ALAMAT IBU',
        ];
    }

    public function map($student): array
    {
        return [
            ++$this->index, // Nomor urut otomatis
            $student->nisn,
            $student->local_nis,
            $student->full_name,
            $student->birth_place,
            $student->birth_date,
            $student->gender ? $student->gender->name : '-',
            $student->religion ? $student->religion->name : '-',
            $student->address . ' ' . $student->rt . ' ' . $student->rw,
            $student->parent ? $student->parent->father_full_name : '-',
            $student->parent ? $student->parent->father_birth_place : '-',
            $student->parent ? $student->parent->father_birth_date : '-',
            $student->parent ? $student->parent->father_address : '-',
            $student->parent ? $student->parent->mother_full_name : '-',
            $student->parent ? $student->parent->mother_birth_place : '-',
            $student->parent ? $student->parent->mother_birth_date : '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A', 'G') as $column) { // Sesuaikan dengan jumlah kolom
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

    public function columnFormats(): array
    {
        // Mengatur format kolom B dan C menjadi teks
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Kolom B menjadi teks
            'C' => NumberFormat::FORMAT_TEXT, // Kolom C menjadi teks
        ];
    }
}

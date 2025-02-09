<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TeacherExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    private $index = 0; // Variabel index untuk nomor urut

    /**
     * Ambil semua data guru sesuai urutan
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Teacher::with('gender', 'religion')->orderBy('full_name', 'asc')->get();
    }

    /**
     * Judul kolom di file Excel
     * @return array
     */
    public function headings(): array
    {
        return [
            'NO',
            'NAMA LENGKAP',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'AGAMA',
            'ALAMAT',
        ];
    }

    /**
     * Atur format data yang diekspor dengan nomor urut
     * @param \App\Models\Teacher $teacher
     * @return array
     */
    public function map($teacher): array
    {
        return [
            ++$this->index, // Nomor urut otomatis
            $teacher->full_name,
            $teacher->brith_place,
            $teacher->birth_date,
            $teacher->gender ? $teacher->gender->name : '-',
            $teacher->religion ? $teacher->religion->name : '-',
            $teacher->full_address,
        ];
    }

    /**
     * Mengatur Auto Size Column setelah sheet dibuat
     * @return array
     */
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
}

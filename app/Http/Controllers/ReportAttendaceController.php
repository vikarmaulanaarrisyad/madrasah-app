<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\LearningActivity;
use App\Models\Student;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportAttendaceController extends Controller
{
    public function index()
    {
        return view('admin.report.attendace.index');
    }

    public function filterPresensi(Request $request)
    {
        $bulan = (int) $request->bulan;

        if (!$bulan) {
            return response()->json(['message' => 'Bulan tidak boleh kosong'], 400);
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::now()->month($bulan)->translatedFormat('F');

        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Ambil guru yang login
        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            return response()->json(['message' => 'Guru tidak ditemukan'], 404);
        }

        // Ambil semua siswa yang diajar oleh guru yang sedang login
        $students = Student::whereHas('learningActivities', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('id'); // Ambil hanya ID siswa

        // Jika tidak ada siswa, langsung return dengan data kosong
        if ($students->isEmpty()) {
            return response()->json([
                'data' => [],
                'count' => 0,
                'message' => "Tidak ada data presensi untuk bulan $namaBulan",
                'namaBulan' => $namaBulan
            ]);
        }

        // Menghitung jumlah hari dalam bulan yang dipilih
        $jumlahHari = Carbon::now()->month($bulan)->daysInMonth();

        // Ambil data presensi berdasarkan bulan yang dipilih dan guru yang login
        $presensi = Attendances::whereIn('student_id', $students)
            ->whereMonth('date', $bulan)
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data agar lebih mudah ditampilkan dalam tabel
        $data = [];

        foreach ($students as $studentId) {
            $student = Student::find($studentId);
            $data[$student->full_name] = array_fill(1, $jumlahHari, 'A');
        }

        foreach ($presensi as $p) {
            $namaSiswa = $p->student->full_name;
            $tanggal = Carbon::parse($p->date)->day; // Ambil angka tanggal (1-31)

            // Tentukan simbol berdasarkan status kehadiran
            $statusSymbol = match ($p->status) {
                'Hadir' => 'H',
                'Izin' => 'I',
                'Sakit' => 'S',
                'Alpha' => 'A',
                default => 'A',
            };

            // Simpan status kehadiran pada tanggal yang sesuai
            $data[$namaSiswa][$tanggal] = $statusSymbol;
        }

        return response()->json([
            'data' => $data,
            'count' => $jumlahHari,
            'message' => "Data presensi untuk bulan $namaBulan",
            'namaBulan' => $namaBulan
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $bulan = (int) $request->bulan;

        if (!$bulan) {
            return response()->json(['message' => 'Bulan tidak boleh kosong'], 400);
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Ambil guru yang login
        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            return response()->json(['message' => 'Guru tidak ditemukan'], 404);
        }

        // Ambil kelas yang diajar oleh guru
        $kelas = LearningActivity::where('teacher_id', $teacher->id)
            ->with('level')
            ->first(); // Pastikan ada kelas yang ditemukan

        // Ambil semua siswa yang diajar oleh guru yang sedang login
        $students = Student::whereHas('learningActivities', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->pluck('id');

        // Jika tidak ada siswa, langsung return dengan data kosong
        if ($students->isEmpty()) {
            return response()->json([
                'data' => [],
                'count' => 0,
                'message' => "Tidak ada data presensi untuk bulan $namaBulan",
                'namaBulan' => $namaBulan
            ]);
        }

        // Menghitung jumlah hari dalam bulan yang dipilih
        $jumlahHari = Carbon::create(null, $bulan)->daysInMonth();

        // Ambil data presensi dengan relasi student
        $presensi = Attendances::whereIn('student_id', $students)
            ->whereMonth('date', $bulan)
            ->with('student') // Load student untuk menghindari error undefined key
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data agar lebih mudah ditampilkan dalam tabel
        $data = [];

        foreach ($students as $studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $data[$student->nisn] = [
                    'nis' => $student->local_nis ?? '-',
                    'nama' => $student->full_name,
                    'nisn' => $student->nisn,
                    'jumlahHari' => $jumlahHari,
                    'kehadiran' => array_fill(1, $jumlahHari, 'A') // Default Alpha (A)
                ];
            }
        }

        foreach ($presensi as $p) {
            if (!$p->student) {
                continue; // Lewati jika student tidak ada
            }

            $nisn = $p->student->nisn ?? '-';
            $tanggal = Carbon::parse($p->date)->day;

            // Tentukan simbol berdasarkan status kehadiran
            $statusSymbol = match ($p->status) {
                'Hadir' => 'H',
                'Izin' => 'I',
                'Sakit' => 'S',
                'Alpha' => 'A',
                default => 'A',
            };

            // Simpan status kehadiran pada tanggal yang sesuai
            $data[$nisn]['kehadiran'][$tanggal] = $statusSymbol;
        }

        // Load PDF dari view Blade dengan ukuran A4 & landscape
        $pdf = Pdf::loadView('admin.report.attendace.pdf', compact(
            'data',
            'namaBulan',
            'jumlahHari',
            'teacher',
            'kelas'
        ))->setPaper('a4', 'landscape');

        // Tampilkan di browser sebelum bisa di-download
        return $pdf->stream("presensi-bulan-$bulan.pdf");
    }
}

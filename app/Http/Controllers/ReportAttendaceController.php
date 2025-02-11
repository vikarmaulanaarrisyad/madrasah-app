<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\LearningActivity;
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

    public function filterPresensi1(Request $request)
    {
        $bulan = (int) $request->bulan;

        if (!$bulan) {
            return response()->json(['message' => 'Bulan tidak boleh kosong'], 400);
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // Ambil data presensi berdasarkan bulan yang dipilih
        $presensi = Attendances::with('student')
            ->whereMonth('date', $bulan)
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data agar lebih mudah ditampilkan dalam tabel
        $data = [];
        foreach ($presensi as $p) {
            $namaSiswa = $p->student->full_name;
            $tanggal = Carbon::parse($p->date)->day; // Ambil angka tanggal (1-31)

            // Jika belum ada data siswa, buat array default dengan nilai '-'
            if (!isset($data[$namaSiswa])) {
                $data[$namaSiswa] = array_fill(1, 31, '-');
            }

            // Tentukan simbol berdasarkan status kehadiran
            $statusSymbol = match ($p->status) {
                'Hadir' => 'H',
                'Izin' => 'I',
                'Sakit' => 'S',
                'Alpha' => 'A',
                default => '-',
            };

            // Simpan status kehadiran pada tanggal yang sesuai
            $data[$namaSiswa][$tanggal] = $statusSymbol;
        }

        return response()->json([
            'data' => $data,
            'message' => "Data presensi untuk bulan $namaBulan",
            'namaBulan' => $namaBulan
        ]);
    }

    public function filterPresensi(Request $request)
    {
        $bulan = (int) $request->bulan;

        if (!$bulan) {
            return response()->json(['message' => 'Bulan tidak boleh kosong'], 400);
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // Ambil ID guru yang sedang login
        $teacherId = Auth::user()->id;

        // menghitung jumlah hari
        $jumlahHari = Carbon::create(null, $bulan)->daysInMonth();

        // Ambil data presensi berdasarkan bulan yang dipilih dan guru yang login
        $presensi = Attendances::with('student.learningActivities')
            ->whereMonth('date', $bulan)
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data agar lebih mudah ditampilkan dalam tabel
        $data = [];
        foreach ($presensi as $p) {
            $namaSiswa = $p->student->full_name;
            $tanggal = Carbon::parse($p->date)->day; // Ambil angka tanggal (1-31)

            // Jika belum ada data siswa, buat array default dengan nilai '-'
            if (!isset($data[$namaSiswa])) {
                $data[$namaSiswa] = array_fill(1, $jumlahHari, 'A');
            }

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

    public function downloadPdf1(Request $request)
    {
        $bulan = (int) $request->query('bulan');

        if (!$bulan) {
            return back()->with('error', 'Bulan tidak boleh kosong.');
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // Ambil ID guru yang sedang login
        $teacherId = Auth::user()->id;

        // menghitung jumlah hari
        $jumlahHari = Carbon::create(null, $bulan)->daysInMonth();

        // Ambil data presensi sesuai filterPresensi
        $presensi = Attendances::with('student.learningActivities')
            ->whereMonth('date', $bulan)
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data sesuai dengan `filterPresensi`
        $data = [];
        foreach ($presensi as $p) {
            $namaSiswa = $p->student->full_name;
            $nisn = $p->student->nisn;
            $tanggal = Carbon::parse($p->date)->day; // Ambil angka tanggal (1-31)

            // Jika belum ada data siswa, buat array default dengan nilai '-'
            if (!isset($data[$namaSiswa])) {
                $data[$namaSiswa] = array_fill(1, $jumlahHari, 'A');
                $data[$namaSiswa]['nisn'] = $nisn; // Simpan NISN dalam array siswa
            }

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


        // Load PDF dari view Blade dengan ukuran F4 & landscape
        $pdf = Pdf::loadView('admin.report.attendace.pdf', compact('data', 'namaBulan', 'jumlahHari',))
            ->setPaper('a4', 'landscape'); // Ukuran F4 dalam mm & landscape

        // Tampilkan dulu di browser sebelum bisa di-download
        return $pdf->stream("presensi-bulan-$bulan.pdf");
    }

    public function downloadPdf(Request $request)
    {
        $bulan = (int) $request->query('bulan');

        if (!$bulan) {
            return back()->with('error', 'Bulan tidak boleh kosong.');
        }

        // Konversi angka bulan ke nama bulan
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // Ambil ID guru yang sedang login
        $teacherId = Auth::user()->id;

        // Ambil informasi guru yang sedang login
        $teacher = Teacher::where('user_id', $teacherId)->first();

        if (!$teacher) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Ambil kelas yang diajar oleh guru
        $kelas = LearningActivity::where('teacher_id', $teacher->id)
            ->with('level')
            ->first();

        // Menghitung jumlah hari dalam bulan yang dipilih
        $jumlahHari = Carbon::create(null, $bulan)->daysInMonth();

        // Ambil data presensi sesuai filterPresensi
        $presensi = Attendances::with('student.learningActivities')
            ->whereMonth('date', $bulan)
            ->orderBy('date', 'asc')
            ->get();

        // Buat struktur data sesuai dengan `filterPresensi`
        $data = [];
        foreach ($presensi as $p) {
            $namaSiswa = $p->student->full_name;
            $nisn = $p->student->nisn;
            $tanggal = Carbon::parse($p->date)->day; // Ambil angka tanggal (1-31)

            // Jika belum ada data siswa, buat array default dengan nilai '-'
            if (!isset($data[$namaSiswa])) {
                $data[$namaSiswa] = array_fill(1, $jumlahHari, 'A');
                $data[$namaSiswa]['nisn'] = $nisn; // Simpan NISN dalam array siswa
            }

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

        // Load PDF dari view Blade dengan ukuran F4 & landscape
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

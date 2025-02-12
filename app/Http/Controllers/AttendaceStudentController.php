<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendances;
use Illuminate\Http\Request;
use App\Models\Student; // Pastikan model Student ada

class AttendaceStudentController extends Controller
{
    public function index()
    {
        // Ambil semua data siswa dengan aktivitas belajar dan kehadiran hari ini
        $students = Student::with(['learningActivities.level', 'attendance' => function ($query) {
            $query->where('date', date('Y-m-d')); // Filter presensi hanya untuk hari ini
        }])->orderBy('full_name', 'asc')->get();

        // Kirim data ke view
        return view('teacher.attendance.student.index', compact('students'));
    }


    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        // Ambil tahun akademik aktif
        $academicYear = AcademicYear::where('is_active', 1)->first();

        if (!$academicYear) {
            return response()->json(['error' => 'Tahun akademik tidak ditemukan'], 400);
        }

        $tglIni = date('Y-m-d');

        // Cek apakah sudah ada presensi hari ini untuk student_id tertentu
        $attendance = Attendances::where('student_id', $request->student_id)
            ->where('date', $tglIni)
            ->first();

        if ($attendance) {
            // Jika sudah ada, update statusnya saja
            $attendance->update([
                'status' => $request->status
            ]);
        } else {
            // Jika belum ada, buat presensi baru
            Attendances::create([
                'academic_year_id' => $academicYear->id,
                'student_id' => $request->student_id,
                'date' => $tglIni,
                'status' => $request->status,
            ]);
        }

        return response()->json(['success' => 'Presensi berhasil disimpan'], 200);
    }
}

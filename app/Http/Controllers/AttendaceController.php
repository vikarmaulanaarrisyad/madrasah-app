<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendances;
use App\Models\LearningActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendaceController extends Controller
{
    public function index(Request $request, $learningActivityId)
    {
        $date = $request->query('date'); // Ambil tanggal dari query

        $learningActivity = LearningActivity::with('students')->findOrFail($learningActivityId);
        $academicYears = AcademicYear::all(); // Ambil semua tahun ajaran

        $attendances = Attendances::where('date', $date)
            ->whereIn('student_id', $learningActivity->students->pluck('id'))
            ->get()
            ->keyBy('student_id'); // Gunakan keyBy agar data bisa diakses dengan student_id

        return view('admin.attendance.index', compact('learningActivity', 'attendances', 'date', 'academicYears'));
    }

    public function store(Request $request, $learningActivityId)
    {
        // Validasi input
        $request->validate([
            'attendance_date' => 'required|date',
            'academic_year_id' => 'required',
            'attendance' => 'required|array',
        ]);

        // Ambil tanggal dari request atau default ke hari ini
        $date = $request->input('attendance_date', Carbon::today()->format('Y-m-d'));
        $academicYearId = $request->input('academic_year_id');
        $attendances = $request->input('attendance', []);

        // Hanya simpan siswa yang memiliki status (tidak null atau kosong)
        foreach ($attendances as $studentId => $status) {
            if (!empty($status)) { // Hanya menyimpan jika status diisi
                Attendances::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'date' => $date,
                        'academic_year_id' => $academicYearId,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Presensi berhasil disimpan!']);
    }

    // Show attendance for a specific rombel
    public function show(Request $request, $id)
    {
        $date = $request->query('date', Carbon::today()->format('Y-m-d')); // Ambil tanggal dari query

        $learningActivity = LearningActivity::with('students')->findOrFail($id);
        $academicYears = AcademicYear::all(); // Ambil semua tahun ajaran

        $attendances = Attendances::where('date', $date)
            ->whereIn('student_id', $learningActivity->students->pluck('id'))
            ->get()
            ->keyBy('student_id'); // Gunakan keyBy agar data bisa diakses dengan student_id

        return view('admin.attendance.index', compact('learningActivity', 'attendances', 'date', 'academicYears'));
    }

    public function filterAttendance(Request $request)
    {
        $date = $request->input('date');

        $learningActivityId = $request->input('learningActivity');

        // Ambil data aktivitas pembelajaran
        $learningActivity = LearningActivity::find($learningActivityId);

        // Ambil semua siswa yang terdaftar dalam aktivitas pembelajaran ini
        $students = $learningActivity->students;

        // Ambil data presensi berdasarkan tanggal yang dipilih
        $attendances = Attendances::whereIn('student_id', $students->pluck('id'))
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        // Kembalikan data dalam format JSON
        return response()->json([
            'students' => $students,
            'attendances' => $attendances
        ]);
    }
}

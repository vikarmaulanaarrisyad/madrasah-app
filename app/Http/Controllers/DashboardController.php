<?php

namespace App\Http\Controllers;

use App\Models\AttendaceTeacher;
use App\Models\Attendances;
use App\Models\LearningActivity;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login, ambil user yang sedang login
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $teacherCount = Teacher::count();
            $studentCount = Student::count();
            $learningActivityCount = LearningActivity::count();
            $subjectCount = Subject::count();

            return view('admin.dashboard.index', compact('teacherCount', 'studentCount', 'learningActivityCount', 'subjectCount'));
        } else if ($user->hasRole('Kepala')) {
            return view('kepalamadrasah.dashboard.index');
        } else {
            $tglIni = date('Y-m-d');
            $bulanIni = date('m') * 1; // Mendapatkan bulan saat ini
            $tahunIni = date('Y'); // Mendapatkan tahun saat ini

            $teacher = Teacher::where('user_id', $user->id)->first();

            $presensiHariIni = AttendaceTeacher::where('teacher_id', $teacher->id)
                ->where('tgl_presensi', $tglIni)
                ->first();

            $historyBulanIni = AttendaceTeacher::where('teacher_id', $teacher->id)
                ->whereMonth('tgl_presensi', $bulanIni)
                ->whereYear('tgl_presensi', $tahunIni)
                ->orderBy('tgl_presensi', 'desc')
                ->get();

            $jumlahHadir = AttendaceTeacher::where('teacher_id', $teacher->id)
                ->whereMonth('tgl_presensi', $bulanIni)
                ->whereYear('tgl_presensi', $tahunIni)
                ->count();

            $jumlahTerlambat = AttendaceTeacher::where('teacher_id', $teacher->id)
                ->whereMonth('tgl_presensi', $bulanIni)
                ->whereYear('tgl_presensi', $tahunIni)
                ->whereTime('jam_in', '>', '07:00:00') // Menambahkan kondisi keterlambatan
                ->count();

            $students = Student::whereHas('learningActivities', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->orderBy('full_name', 'Asc')->get();

            // Ambil semua data siswa dengan aktivitas belajar dan kehadiran hari ini
            $studentsHadir = Student::whereHas('attendance', function ($query) {
                $query->where('date', date('Y-m-d'))
                    ->where('status', 'Hadir');
            })->count();
            $studentsIzin = Student::whereHas('attendance', function ($query) {
                $query->where('date', date('Y-m-d'))
                    ->where('status', 'Izin');
            })->count();
            $studentsSakit = Student::whereHas('attendance', function ($query) {
                $query->where('date', date('Y-m-d'))
                    ->where('status', 'Sakit');
            })->count();
            $studentsAlpa = Student::whereHas('attendance', function ($query) {
                $query->where('date', date('Y-m-d'))
                    ->where('status', 'Alpa');
            })->count();

            $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            return view('teacher.dashboard.index', compact(['presensiHariIni', 'studentsSakit', 'studentsIzin', 'studentsAlpa', 'tglIni', 'studentsHadir', 'students', 'historyBulanIni', 'namaBulan', 'bulanIni', 'tahunIni', 'jumlahHadir', 'jumlahTerlambat']));
        }
    }
}

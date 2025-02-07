<?php

namespace App\Http\Controllers;

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
            return view('teacher.dashboard.index');
        }
    }
}

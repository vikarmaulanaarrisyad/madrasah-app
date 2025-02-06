<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AttendaceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LearningActivityController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
    // return view ('teachers.jurnal.pdf');
});

Route::group(['middleware' => ['auth']], function () {
    // Route : Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['midleware' => ['role:Admin|Kepala']], function () {
        Route::get('/academicyears/data', [AcademicYearController::class, 'data'])->name('academicyears.data');
        Route::resource('/academicyears', AcademicYearController::class);
        Route::put('/academicyears/{id}/update-status', [AcademicYearController::class, 'updateStatus'])->name('academicyears.updateStatus');

        // Route : Teacher / GTK
        Route::get('/teachers/data', [TeacherController::class, 'data'])->name('teachers.data');
        Route::resource('/teachers', TeacherController::class);

        // Route : Student
        Route::get('/students/data', [StudentController::class, 'data'])->name('students.data');
        Route::resource('/students', StudentController::class);

        Route::post('/parents', [ParentController::class, 'store'])->name('parents.store');

        // Route : LearningActivity / Rombel
        Route::get('/rombel/data', [LearningActivityController::class, 'data'])->name('rombel.data');
        Route::resource('/rombel', LearningActivityController::class);
        Route::post('/rombel/{learningActivity}/add-student', [LearningActivityController::class, 'addStudent'])->name('rombel.addStudent');
        Route::get('/rombel/rombel-detail/{id}', [LearningActivityController::class, 'detail'])->name('rombel.detail');
        Route::delete('/rombel/{learningActivityId}/removeStudent/{studentId}', [LearningActivityController::class, 'removeStudent'])->name('rombel.removeStudent');

        // Route::get('/rombel/{id}/attendance', [AttendaceController::class, 'index'])->name('attendance.index');
        Route::get('/rombel/{id}/attendance', [AttendaceController::class, 'show'])->name('attendance.show');
        Route::get('/attendance/filter', [AttendaceController::class, 'filterAttendance'])->name('attendance.filterAttendance');
        Route::post('/rombel/{id}/attendance', [AttendaceController::class, 'store'])->name('attendance.store');

        // Route : Subject / Mata Pelajaran
        Route::get('/subjects/data', [SubjectController::class, 'data'])->name('subjects.data');
        Route::resource('/subjects', SubjectController::class);
    });
});

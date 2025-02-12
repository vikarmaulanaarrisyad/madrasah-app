<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AttendaceController;
use App\Http\Controllers\AttendaceTeacherController;
use App\Http\Controllers\CuriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\LearningActivityController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ReportAttendaceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachingJournalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {
    // Route : Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['midleware' => ['role:Admin']], function () {
        Route::get('/academicyears/data', [AcademicYearController::class, 'data'])->name('academicyears.data');
        Route::resource('/academicyears', AcademicYearController::class);
        Route::put('/academicyears/{id}/update-status', [AcademicYearController::class, 'updateStatus'])->name('academicyears.updateStatus');

        // Route : Teacher / GTK
        Route::get('/teachers/data', [TeacherController::class, 'data'])->name('teachers.data');
        Route::get('/teachers/export-excel', [TeacherController::class, 'exportExcel'])->name('teachers.export_excel');
        Route::post('/teachers/import-excel', [TeacherController::class, 'importExcel'])->name('teachers.import_excel');
        Route::resource('/teachers', TeacherController::class);

        // Route : Student
        Route::get('/students/data', [StudentController::class, 'data'])->name('students.data');
        Route::get('/students/export-excel', [StudentController::class, 'exportExcel'])->name('students.export_excel');
        Route::post('/students/import-excel', [StudentController::class, 'importExcel'])->name('students.import_excel');
        Route::get('/students/print-induk/{id}', [StudentController::class, 'printInduk'])->name('students.print_induk');
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

        // Route : Curiculums / Kurikulum
        Route::get('/curiculums/data', [CuriculumController::class, 'data'])->name('curiculums.data');
        Route::resource('/curiculums', CuriculumController::class);

        // Route : Subject / Mata Pelajaran
        Route::get('/subjects/data', [SubjectController::class, 'data'])->name('subjects.data');
        Route::resource('/subjects', SubjectController::class);

        // Route : Journal
        Route::get('/journals/data', [TeachingJournalController::class, 'data'])->name('journals.data');
        Route::get('/journals/get-subject', [TeachingJournalController::class, 'getSubject'])->name('journals.get_subject');
        Route::get('/journals/get-learningactivity', [TeachingJournalController::class, 'getLearningActivity'])->name('journals.get_learning_activity');
        Route::get('/journals/download-pdf', [TeachingJournalController::class, 'exportPDF'])->name('journals.download_pdf');
        Route::resource('/journals', TeachingJournalController::class);

        Route::resource('/settings', SettingController::class);
        Route::resource('/institution', InstitutionController::class);

        // Route::get('/report-attendace/data', [ReportAttendaceController::class, 'data'])->name('report.attendace_data');
        Route::get('/report-attendace/filter', [ReportAttendaceController::class, 'filterPresensi'])->name('presensi.filter');
        Route::get('/report-attendace/download', [ReportAttendaceController::class, 'downloadPdf'])->name('presensi.download');
        Route::resource('/report-attendace', ReportAttendaceController::class);
    });

    Route::group(['middleware' => ['role:Guru']], function () {
        Route::get('/presensi/create', [AttendaceTeacherController::class, 'create'])->name('attendace.teacher_create');
        Route::post('/presensi/store', [AttendaceTeacherController::class, 'store'])->name('attendace.teacher_store');
    });
});

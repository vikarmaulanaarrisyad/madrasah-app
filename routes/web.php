<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
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
    });
});

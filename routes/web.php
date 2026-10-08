<?php

use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StrandController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('/app/dashboard', 'application.dashboard')->name('app.dashboard');
Route::resource('/app/students', StudentController::class);

Route::get('/app/student/create_file', [StudentController::class, 'create_file'])->name('student.create_file');
Route::post('/app/student/store_file', [StudentController::class, 'store_file'])->name('student.store_file');
Route::delete('/app/student/destroy_file/{file_id}', [StudentController::class, 'destroy_file'])->name('student.destroy_file');

Route::resource('/app/strands', StrandController::class);
Route::resource('/app/grade_levels', GradeLevelController::class);
Route::resource('/app/school_years', SchoolYearController::class);

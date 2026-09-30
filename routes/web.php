<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('/app/dashboard', 'application.dashboard')->name('app.dashboard');
Route::resource('/students', StudentController::class);

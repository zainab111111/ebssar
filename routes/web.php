<?php

use App\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/courses', [CoursesController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('courses');

Route::get('/courses/{course}', function ($course) {
    return Inertia::render('Course', [
        'course' => $course,
    ]);
})->middleware(['auth', 'verified'])->name('course');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/courses', [CourseController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('courses.index');

Route::get('/courses/{course}', [CourseController::class, 'show'])
    ->middleware(['auth', 'verified'])->name('courses.show');

Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'showLesson'])
    ->name('courses.lessons.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

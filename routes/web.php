<?php

use App\Http\Controllers\ContactFormController;
use App\Http\Resources\CourseResource;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SearchController;
use App\Models\Course;
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
    ->middleware(['auth', 'verified'])->name('courses.lessons.show');

Route::post('/courses/{course}/lessons/{lesson}/complete', [CourseController::class, 'completeLesson'])
    ->middleware(['auth', 'verified'])
    ->name('courses.lessons.complete');

Route::get('/courses-list', function () {

    $courses = Course::all()->load('userCourses');
    return Inertia::render('CoursesListPage', [
        'courses' => CourseResource::collection($courses)->resolve(),
    ]);
})->name('courses-list');

Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

Route::get('/search', [SearchController::class, 'search']);
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Response;

class CoursesController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $courses = Course::all();
        return inertia('Courses', [
            'courses' => $courses,
        ]);
    }
}

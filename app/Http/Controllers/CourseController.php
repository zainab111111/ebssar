<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Course::all();
        return inertia('Courses/Index', [
            'courses' => CourseResource::collection($courses)->resolve(),
        ]);
    }

    /**
     * Display the specified resource (course overview).
     */
    public function show(Course $course, Request $request): Response
    {
        $course->load(['lessons' => function ($query) {
            $query->orderBy('index');
        }]);

        if ($request->user()) {
            $course->load(['userCourses' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);

            $course->lessons->load(['userLessons' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);
        }

        return inertia('Courses/Show', [
            'course' => (new CourseResource($course))->resolve(),
            'lessons' => LessonResource::collection($course->lessons)->resolve(),
        ]);
    }

    /**
     * Display a specific lesson within a course.
     */
    public function showLesson(Course $course, Lesson $lesson, Request $request): Response
    {
        // Ensure the lesson belongs to the course
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $course->load(['lessons' => function ($query) {
            $query->orderBy('index');
        }]);

        if ($request->user()) {
            $course->load(['userCourses' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);

            $course->lessons->load(['userLessons' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);

            // Load user lesson data for the current lesson
            $lesson->load(['userLessons' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);
        }

        return inertia('Courses/Show', [
            'course' => (new CourseResource($course))->resolve(),
            'lessons' => LessonResource::collection($course->lessons)->resolve(),
            'currentLesson' => (new LessonResource($lesson))->resolve(),
        ]);
    }
}

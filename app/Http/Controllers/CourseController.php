<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\UserLesson;
use Illuminate\Http\Request;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Course::all()->load('userCourses');
        return inertia('Courses/Index', [
            'courses' => CourseResource::collection($courses)->resolve(),
        ]);
    }

    /**
     * Display the specified resource (course overview).
     */
    // app/Http/Controllers/CourseController.php

    public function show(Course $course, Request $request): Response|\Illuminate\Http\RedirectResponse
    {
        // Auto-enroll user in course if authenticated
        if ($request->user()) {
            UserCourse::firstOrCreate(
                [
                    'user_id' => $request->user()->id,
                    'course_id' => $course->id,
                ],
                ['is_completed' => false]
            );
        }

        // Always have lessons ordered
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

        // If there are lessons, redirect to the "current" lesson
        $currentLesson = $this->determineCurrentLesson($course, $request->user()?->id);

        if ($currentLesson) {
            return redirect()->route('courses.lessons.show', [
                'course' => $course->id,
                'lesson' => $currentLesson->id,
            ]);
        }

        // No lessons: render the overview
        return inertia('Courses/Show', [
            'course' => (new CourseResource($course))->resolve(),
            'lessons' => LessonResource::collection($course->lessons)->resolve(),
        ]);
    }

    /**
     * Determine the current lesson for a user:
     * - First incomplete lesson (by index)
     * - If none incomplete, the first lesson
     * - If no user, just the first lesson
     */
    private function determineCurrentLesson(Course $course, ?int $userId): ?Lesson
    {
        if ($course->lessons->isEmpty()) {
            return null;
        }

        // If user known, pick first incomplete for them
        if ($userId) {
            // Build a set of completed lesson ids for this user in one query
            $completedIds = UserLesson::where('user_id', $userId)
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->where('is_completed', true)
                ->pluck('lesson_id')
                ->toArray();

            $firstIncomplete = $course->lessons
                ->sortBy('index')
                ->first(function (Lesson $l) use ($completedIds) {
                    return !in_array($l->id, $completedIds, true);
                });

            if ($firstIncomplete) {
                return $firstIncomplete;
            }
        }

        // Fallback: first lesson by index
        return $course->lessons->sortBy('index')->first();
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

        if ($request->user()) {
            // Auto-enroll user in course if not already enrolled
            UserCourse::firstOrCreate([
                'user_id' => $request->user()->id,
                'course_id' => $course->id,
            ], [
                'is_completed' => false,
            ]);

            // Automatically mark lesson as completed when opened
            UserLesson::updateOrCreate([
                'user_id' => $request->user()->id,
                'lesson_id' => $lesson->id,
            ], [
                'is_completed' => true, // Auto-complete on access
            ]);

            // Check if all lessons in the course are completed after marking this one
            $this->checkAndUpdateCourseCompletion($course, $request->user()->id);
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

    /**
     * Check and update course completion status.
     */
    private function checkAndUpdateCourseCompletion(Course $course, int $userId): void
    {
        $totalLessons = $course->lessons()->count();
        $completedLessons = UserLesson::where('user_id', $userId)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->where('is_completed', true)
            ->count();

        // If all lessons are completed, mark course as completed
        if ($totalLessons === $completedLessons && $totalLessons > 0) {
            UserCourse::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->update(['is_completed' => true]);
        }
    }

    /**
     * Manually mark a lesson as completed (optional - for cases where you want manual control).
     */
    public function completeLesson(Course $course, Lesson $lesson, Request $request): Response
    {
        if (!$request->user()) {
            abort(401);
        }

        // Ensure the lesson belongs to the course
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Mark lesson as completed
        UserLesson::updateOrCreate([
            'user_id' => $request->user()->id,
            'lesson_id' => $lesson->id,
        ], [
            'is_completed' => true,
        ]);

        $this->checkAndUpdateCourseCompletion($course, $request->user()->id);

        return redirect()->back()->with('success', 'Lesson marked as completed!');
    }
}

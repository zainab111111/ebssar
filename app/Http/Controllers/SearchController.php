<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->get('q', ''));

        // Validate query length
        if (strlen($query) < 2) {
            return response()->json([
                'courses' => [],
                'lessons' => [],
            ]);
        }

        // Cache key for this search query
        $cacheKey = "search:" . md5($query);

        // Try to get from cache first (cache for 5 minutes)
        $results = Cache::remember($cacheKey, 300, function () use ($query) {
            // Search courses with better relevance scoring
            $courses = Course::query()->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%") // If you have description
                ->select('id', 'name')
                ->orderByRaw("CASE WHEN name LIKE '{$query}%' THEN 1 ELSE 2 END") // Prioritize starts-with matches
                ->limit(5)
                ->get();

            $lessons = Lesson::query()->where('title', 'like', "%{$query}%")
                ->with('course:id,name') // Include course info for context
                ->select('id', 'title', 'course_id')
                ->orderByRaw("CASE WHEN title LIKE '{$query}%' THEN 1 ELSE 2 END")
                ->limit(5)
                ->get();

            return [
                'courses' => $courses,
                'lessons' => $lessons,
            ];
        });

        return response()->json($results);
    }
}

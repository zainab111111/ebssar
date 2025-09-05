<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentUser = $request->user();
        $isCompleted = false;
        if ($currentUser && $this->resource->relationLoaded('userCourses')) {
            $userCourse = $this->userCourses->firstWhere('user_id', $currentUser->id);
            $isCompleted = $userCourse ? (bool) $userCourse->is_completed : false;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'is_completed' => $isCompleted,
        ];
    }
}

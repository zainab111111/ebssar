<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
        if ($currentUser && $this->resource->relationLoaded('userLessons')) {
            $userLesson = $this->userLessons->firstWhere('user_id', $currentUser->id);
            $isCompleted = $userLesson ? (bool) $userLesson->is_completed : false;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'index' => $this->index,
            'audio' => $this->audio,
            'content' => $this->content,
            'is_completed' => $isCompleted,
        ];
    }
}

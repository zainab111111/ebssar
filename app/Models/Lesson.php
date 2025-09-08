<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'index', 'audio', 'content'];

    /**
     * @return BelongsTo<Course,Lesson>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return HasMany<UserLesson,Lesson>
     */
    public function userLessons(): HasMany
    {
        return $this->hasMany(UserLesson::class);
    }

    protected $appends = ['audio_url'];

    public function getAudioUrlAttribute(): ?string
    {
        if (!$this->audio) {
            return null;
        }

        // If the audio path is already a full URL, return it as is
        if (str_starts_with($this->audio, 'http')) {
            return $this->audio;
        }

        try {
            // Check if file exists before generating URL
            if (Storage::exists($this->audio)) {
                $url = Storage::url($this->audio);

                // Log for debugging (remove in production)
                Log::info('Generated audio URL', [
                    'lesson_id' => $this->id,
                    'audio_path' => $this->audio,
                    'generated_url' => $url,
                    'file_exists' => Storage::exists($this->audio)
                ]);

                return $url;
            } else {
                Log::warning('Audio file does not exist', [
                    'lesson_id' => $this->id,
                    'audio_path' => $this->audio
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error generating audio URL', [
                'lesson_id' => $this->id,
                'audio_path' => $this->audio,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

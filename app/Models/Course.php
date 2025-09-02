<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    /**
     * @return HasMany<UserCourse,UserCourse>
     */
    public function userCourses(): HasMany
    {
        return $this->hasMany(UserCourse::class);
    }

    /**
     * @return HasMany<Lesson,Lesson>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // If the image path is already a full URL, return it as is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // Generate the full URL for the stored image
        return Storage::url($this->image);
    }
}

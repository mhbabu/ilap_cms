<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'udemy_video_id', // optional, if we want to store Udemy ID separately
        'duration', // in seconds
        'is_free',
        'order',
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    // ── Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
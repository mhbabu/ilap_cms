<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Video;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CourseVideoController extends Controller
{
    /**
     * Display a listing of the videos for a course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Course $course): View
    {
        $user = Auth::user();
        $student = $user->studentProfile;

        // Check if student is enrolled in the course
        if (!$student || !$student->courses()->where('courses.id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $videos = $course->videos()->orderBy('order')->get();

        return view('course-videos.index', compact('course', 'videos', 'student'));
    }

    /**
     * Show the form for creating a new video.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Only for admins/instructors
        abort(403);
    }

    /**
     * Store a newly created video in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only for admins/instructors
        abort(403);
    }

    /**
     * Display the specified video.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        // We'll redirect to the play page
        return redirect()->route('course-videos.play', $video->id);
    }

    /**
     * Show the video play page.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function play(Video $video): View
    {
        $user = Auth::user();
        $student = $user->studentProfile;

        // Check if student is enrolled in the course of this video
        if (!$student || !$student->courses()->where('courses.id', $video->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Load the course for breadcrumbs or sidebar
        $course = $video->course;

        // Get next and previous videos in the course for navigation
        $videos = $course->videos()->orderBy('order')->get();
        $currentIndex = $videos->search($video->id);
        $prevVideo = $currentIndex > 0 ? $videos[$currentIndex - 1] : null;
        $nextVideo = $currentIndex < $videos->count() - 1 ? $videos[$currentIndex + 1] : null;

        return view('course-videos.play', compact(
            'video',
            'course',
            'prevVideo',
            'nextVideo',
            'student'
        ));
    }

    /**
     * Update the specified video in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        // Only for admins/instructors
        abort(403);
    }

    /**
     * Remove the specified video from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        // Only for admins/instructors
        abort(403);
    }
}
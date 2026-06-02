<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of available courses.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $student = $user ? Student::where('email', $user->email)->first() : null;

        $courses = Course::where('is_active', true)->withCount('videos')->get();

        // If student is logged in, check which courses they are enrolled in
        $enrolledCourseIds = [];
        if ($student) {
            $enrolledCourseIds = $student->courses()->pluck('courses.id')->toArray();
        }

        return view('courses.index', compact('courses', 'enrolledCourseIds', 'student'));
    }

    /**
     * Show the form for creating a new course.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Only for admins, but we'll implement later if needed
        abort(403);
    }

    /**
     * Store a newly created course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only for admins
        abort(403);
    }

    /**
     * Display the specified course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        // We'll redirect to the course videos page
        return redirect()->route('course-videos.index', $course->id);
    }

    /**
     * Enroll the authenticated student in a course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $student = Student::where('email', $user->email)->first();
        if (!$student) {
            return back()->with('error', 'Student record not found.');
        }

        // Check if already enrolled
        if ($student->courses()->where('courses.id', $course->id)->exists()) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        // Enroll the student
        $student->courses()->attach($course->id, [
            'enrolled_at' => now(),
            'status' => 'enrolled',
        ]);

        return redirect()->route('course-videos.index', $course->id)
            ->with('success', 'Successfully enrolled in the course.');
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        // Only for admins
        abort(403);
    }

    /**
     * Show the courses the current student is enrolled in.
     *
     * @return \Illuminate\Http\Response
     */
    public function myCourses(Request $request): View
    {
        $user = Auth::user();
        $student = $user ? Student::where('email', $user->email)->first() : null;

        if (!$student) {
            return redirect()->route('login');
        }

        $courses = $student->courses()
            ->withCount('videos')
            ->wherePivot('course_enrollments.status', 'enrolled')
            ->get();

        return view('courses.my', compact('courses', 'student'));
    }
}
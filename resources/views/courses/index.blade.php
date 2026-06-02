@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Available Courses</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                @foreach ($courses as $course)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text">
                                    {{ str_limit($course->description, 100) }}
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        {{ $course->videos_count }} videos
                                    </small>
                                </p>
                            </div>
                            <div class="card-footer">
                                @if ($student && in_array($course->id, $enrolledCourseIds))
                                    <span class="badge bg-success">Enrolled</span>
                                    <a href="{{ route('course-videos.index', $course->id) }}" class="btn btn-sm btn-primary float-end">
                                        View Videos
                                    </a>
                                @else
                                    <form action="{{ route('course.enroll', $course->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            Enroll
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
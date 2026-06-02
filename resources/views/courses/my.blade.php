@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>My Courses</h1>

            @if ($courses->isEmpty())
                <div class="alert alert-info">
                    You are not enrolled in any courses yet. <a href="{{ route('courses.index') }}">Browse available courses</a>.
                </div>
            @else
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->title }}</h5>
                                    <p class="card-text">
                                        {{ Str::limit($course->description, 100) }}
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ $course->videos_count }} videos
                                        </small>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('course-videos.index', $course->id) }}" class="btn btn-sm btn-primary float-end">
                                        Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
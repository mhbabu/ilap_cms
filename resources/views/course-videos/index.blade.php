@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $course->title }}</h1>
            <p class="lead">{{ $course->description }}</p>

            <a href="{{ route('courses.my') }}" class="btn btn-outline-secondary mb-3">
                ← Back to My Courses
            </a>

            @if ($videos->isEmpty())
                <div class="alert alert-info">
                    No videos available for this course yet.
                </div>
            @else
                <div class="row">
                    @foreach ($videos as $video)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $video->title }}</h5>
                                    <p class="card-text">
                                        {{ str_limit($video->description, 100) }}
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            @if ($video->duration)
                                                {{ floor($video->duration / 60) }}:{{ str_pad($video->duration % 60, 2, '0', STR_PAD_LEFT) }} min
                                            @endif
                                            @if ($video->is_free)
                                                <span class="badge bg-success">Free</span>
                                            @else
                                                <span class="badge bg-secondary">Premium</span>
                                            @endif
                                        </small>
                                    </p>
                                </div>
                                <div class="card-footer d-grid">
                                    <a href="{{ route('course-videos.play', $video->id) }}" class="btn btn-primary">
                                        <i class="bi bi-play-fill me-1"></i> Play Video
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
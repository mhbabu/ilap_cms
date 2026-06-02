@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="ratio ratio-16x9">
                @php
                    $isYouTube = str_contains($video->video_url, 'youtube.com') || str_contains($video->video_url, 'youtu.be');
                    $isMp4 = str_ends_with($video->video_url, '.mp4');
                @endphp
                @if ($isYouTube)
                    <iframe src="{{ $video->video_url }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @elseif ($isMp4)
                    <video controls>
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <!-- For other URLs, we just link to it -->
                    <a href="{{ $video->video_url }}" target="_blank" class="btn btn-outline-primary">
                        Watch Video (opens in new tab)
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ $video->title }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $video->description }}
                    </p>
                    <hr>
                    <div>
                        <strong>Course:</strong> <a href="{{ route('course-videos.index', $video->course_id) }}">{{ $course->title }}</a>
                    </div>
                    <div class="mt-2">
                        @if ($video->duration)
                            <strong>Duration:</strong> {{ floor($video->duration / 60) }}:{{ str_pad($video->duration % 60, 2, '0', STR_PAD_LEFT) }} min
                        @endif
                    </div>
                    <div class="mt-2">
                        @if ($video->is_free)
                            <span class="badge bg-success">Free Preview</span>
                        @else
                            <span class="badge bg-secondary">Enrolled Only</span>
                        @endif
                    </div>
                </div>
            </div>

            @if ($prevVideo || $nextVideo)
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Navigation</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                                @if ($prevVideo)
                                    <a href="{{ route('course-videos.play', $prevVideo->id) }}" class="btn btn-outline-primary w-100 mb-2">
                                        ← Previous: {{ str_limit($prevVideo->title, 30) }}
                                    </a>
                                @endif
                                @if ($nextVideo)
                                    <a href="{{ route('course-videos.play', $nextVideo->id) }}" class="btn btn-outline-primary w-100">
                                        Next: {{ str_limit($nextVideo->title, 30) }} →
                                    </a>
                                @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
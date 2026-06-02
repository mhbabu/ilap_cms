@extends('layouts.app')

@section('title','Video Player')
@section('page-title','Video Player')

@section('content')
<div class="mb-6">
    <a href="{{ route('videos.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Back to Videos
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <div class="rounded-xl border border-slate-200 bg-black overflow-hidden aspect-video">
            <video id="lesson-video" class="h-full w-full" controls poster="">
                <source src="#" type="video/mp4">
                Your browser does not support video playback.
            </video>
        </div>
        <div class="mt-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">{{ $record->topic }}</h2>
            <p class="text-xs text-slate-500 mt-1">Class: {{ $record->classData->name ?? '—' }} • Module: {{ $record->module?->name ?? '—' }} • Teacher: {{ $record->teacher->name ?? '—' }}</p>
            <p class="text-xs text-slate-500">Date: {{ $record->record_date }}</p>
            @if($record->auto_transcript)
            <div class="mt-4 rounded-lg bg-slate-50 p-3">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Transcript</p>
                <p class="text-sm text-slate-700">{{ $record->auto_transcript }}</p>
            </div>
            @endif
        </div>
    </div>
    <div>
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-3">
                <h3 class="text-sm font-bold text-slate-900">Class Details</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <p class="text-xs text-slate-500">Student</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $record->student->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Grade</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $record->grade ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Attendance</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $record->attendance ? 'Present' : 'Absent' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Notes</p>
                    <p class="text-sm text-slate-700">{{ $record->notes ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

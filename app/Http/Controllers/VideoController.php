<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\ClassRoom;
use App\Models\Module;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $q = ClassRecord::query()->with(['classData.module','student','teacher'])->latest();
        if ($request->filled('module')) $q->whereHas('classData', fn($q)=>$q->where('module_id',$request->module));
        if ($request->filled('class')) $q->where('class_id',$request->class);
        return $this->withOrg('videos.index', ['records'=>$q->paginate(20)]);
    }

    public function byClass(ClassRoom $class)
    {
        $class->load(['module','records.student','records.teacher']);
        return $this->withOrg('videos.by-class', compact('class'));
    }

    public function play(ClassRecord $record)
    {
        $record->load(['classData.module','student','teacher']);
        return $this->withOrg('videos.play', compact('record'));
    }

    public function updateProgress(Request $request, ClassRecord $record)
    {
        $request->validate([
            'watched_seconds' => 'nullable|integer|min:0',
            'completed'       => 'nullable|boolean',
        ]);
        $record->update([
            'watched_seconds' => $request->watched_seconds ?? ($record->watched_seconds ?? 0),
            'transcript_generated' => $request->boolean('completed') ? true : $record->transcript_generated,
        ]);
        return response()->json(['ok'=>true]);
    }
}

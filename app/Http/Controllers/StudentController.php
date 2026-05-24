<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $q = Student::query()
            ->when($request->filled('campus_id'), fn($q) => $q->where('campus_id',$request->campus_id))
            ->when($request->filled('status'), fn($q) => $q->where('current_step',$request->status))
            ->when($request->filled('handler_id'), fn($q) => $q->where('handler_id',$request->handler_id))
            ->when($request->search, fn($q) => $q->where('name','like',"%{$request->search}%")
                ->orWhere('unique_id','like',"%{$request->search}%"))
            ->when(!auth()->user()?->hasRole('super_admin') && !auth()->user()?->hasRole('hq_admin'),
                fn($q) => $q->where('campus_id', auth()->user()?->campus_id))
            ->latest();

        $students = $q->with(['campus','handler.user'])->paginate(30);
        $campuses  = Campus::active()->get();
        $handlers  = \App\Models\Handler::active()->get();
        $total     = Student::count();

        return $this->withOrg('students.index', compact('students','campuses','handlers','total'));
    }

    public function create(): View
    {
        $campuses = Campus::active()->get();
        $handlers = \App\Models\Handler::active()->get();
        return $this->withOrg('students.create', compact('campuses','handlers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|unique:students,email',
            'phone'          => 'required|string|max:20',
            'campus_id'      => 'required|exists:campuses,id',
            'handler_id'     => 'nullable|exists:handlers,id',
            'passport_number'=> 'nullable|string|max:50',
            'ielts_score'    => 'nullable|numeric|min:0|max:9.9',
            'enrollment_type'=> 'nullable|string|max:100',
            'qualification'  => 'nullable|string',
            'address'        => 'nullable|string',
            'date_of_birth'  => 'nullable|date',
            'parent_phone'   => 'nullable|string',
            'parent_email'   => 'nullable|email',
            'photo'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos','public');
        }

        $validated['unique_id']   = 'STU'.strtoupper(substr(uniqid(),-6));
        $validated['current_step']= 'enrolled';
        $validated['status']      = 'active';

        $student = Student::create($validated);
        return redirect()->route('students.show',$student)->with('success','Student registered.');
    }

    public function show(Student $student): View
    {
        $campusId = $student->campus_id;
        if (!(auth()->user()?->hasRole('super_admin') || auth()->user()?->campus_id == $campusId)) abort(403);

        $student->load(['campus','handler','enrollments.module','enrollments.classData',
            'payments','documents','tickets']);

        $enrollments = $student->enrollments;
        $payments    = $student->payments;
        $documents   = $student->documents;
        $tickets     = $student->tickets;

        return $this->withOrg('students.show', compact('student','enrollments','payments','documents','tickets'));
    }

    public function edit(Student $student): View
    {
        $campuses = Campus::active()->get();
        $handlers = \App\Models\Handler::active()->get();
        return $this->withOrg('students.edit', compact('student','campuses','handlers'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:students,email,'.$student->id,
            'campus_id'      => 'required|exists:campuses,id',
            'handler_id'     => 'nullable|exists:handlers,id',
            'passport_number'=> 'nullable|string|max:50',
            'ielts_score'    => 'nullable|numeric|min:0|max:9.9',
            'enrollment_type'=> 'nullable|string|max:100',
            'current_step'   => 'required|in:registered,payment_pending,enrolled,documents_verified,completed',
            'address'        => 'nullable|string',
            'date_of_birth'  => 'nullable|date',
            'parent_phone'   => 'nullable|string',
            'parent_email'   => 'nullable|email',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos','public');
        }

        $student->update($validated);
        return redirect()->route('students.show',$student)->with('success','Student updated.');
    }

    public function advanceStatus(Student $student): RedirectResponse
    {
        $student->advanceStatus();
        return back()->with('success','Status advanced.');
    }

    public function uploadDocument(Request $request, Student $student): RedirectResponse
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'file'        => 'required|file|max:10240',
            'description' => 'nullable|string',
            'type'        => 'required|in:passport,visa,finance,result,id,other',
        ]);

        $file     = $request->file('file');
        $filename = time().'_'.preg_replace('/[^A-Za-z0-9_\-\.]/','',$file->getClientOriginalName());
        $path     = $file->storeAs('documents/students/'.$student->unique_id, $filename, 'public');

        $student->documents()->create([
            'title'          => $request->title,
            'description'    => $request->description,
            'filename'       => $filename,
            'original_name'  => $file->getClientOriginalName(),
            'path'           => $path,
            'mime'           => $file->getMimeType(),
            'size'           => $file->getSize(),
            'uploaded_by'    => auth()->id(),
            'campus_id'      => $student->campus_id,
            'type'           => $request->type,
        ]);

        return back()->with('success','Document uploaded.');
    }

    public function search(Request $request)
    {
        $term = $request->get('q','');
        $students = Student::where('name','like',"%{$term}%")
            ->orWhere('unique_id','like',"%{$term}%")
            ->limit(20)
            ->get(['id','name','unique_id','campus_id','current_step','phone']);

        $students->each(function ($s) {
            $s->formatted = "{$s->unique_id} | {$s->name}";
        });

        return response()->json(['results'=>$students]);
    }

    public function export(Request $request)
    {
        $students = Student::query()
            ->when(!auth()->user()?->hasRole('super_admin'), fn($q) => $q->where('campus_id',auth()->user()?->campus_id))
            ->with(['campus','handler'])
            ->get();

        $csv = "ID,Name,Phone,Email,Campus,Handler,Status,IELTS\n";
        foreach ($students as $s) {
            $csv .= "{$s->unique_id},\"{$s->name}\",\"{$s->phone}\",{$s->email},{$s->campus?->name},{$s->handler?->name},{$s->current_step},{$s->ielts_score}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students-'.now()->format('Y-m-d').'.csv"',
        ]);
    }
}

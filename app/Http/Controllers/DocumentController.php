<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $q = Document::with('uploader');
        if (!auth()->user()?->hasRole('super_admin') && !auth()->user()?->hasRole('hq_admin')) {
            $q->where('campus_id', $campusId);
        }

        if ($request->filled('type')) {
            $q->where('type',$request->type);
        }

        if ($request->filled('collection')) {
            $q->where('collection',$request->collection);
        }

        $documents = $q->latest()->paginate(24);
        $toBroadcast = Document::where('campus_id', $campusId)->whereNull('broadcast_at')->get();

        return $this->withOrg('documents.index', compact('documents','toBroadcast'));
    }

    public function show(Document $document): View
    {
        return $this->withOrg('documents.show', compact('document'));
    }

    public function sent()
    {
        $documents = Document::where('uploaded_by',auth()->id())->latest()->paginate(20);
        return $this->withOrg('documents.upload-history', compact('documents'));
    }

    public function create(): View
    {
        $campuses = \App\Models\Campus::active()->get();
        $users    = User::orderBy('name')->get();

        $docCounts = [
            'student_alumni' => Document::where('type','alumni_guide')->count(),
            'ce_pipeline'    => Document::where('type','ce_pipeline')->count(),
            'ct_pipeline'    => Document::where('type','ct_pipeline')->count(),
        ];

        return $this->withOrg('documents.create', compact('campuses','users','docCounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'collection'    => 'required|string',
            'file'          => 'required|file|max:20480',
            'campus_id'     => 'required|numeric',
            'student_id'    => 'nullable|numeric',
            'is_guide'      => 'boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('campus-docs','public');

        Document::create([
            'title'          => $validated['title'],
            'collection'     => $validated['collection'],
            'filename'       => $path,
            'path'           => $path,
            'mime'           => $file->getClientMimeType(),
            'size'           => $file->getSize(),
            'uploaded_by'    => auth()->id(),
            'campus_id'      => $validated['campus_id'],
            'opt_out_phones' => '[]',
            'student_id'     => $validated['student_id'] ?? null,
            'is_guide_document'=>$request->boolean('is_guide'),
            'type'           => $validated['collection'],
            'description'    => '',
            'original_name'  => $file->getClientOriginalName(),
        ]);

        return redirect()->route('documents.index')->with('success','Document uploaded.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $document->delete();
        return back()->with('success','Document deleted.');
    }

    public function sendBroadcast(Request $request): RedirectResponse
    {
        $docId = $request->validate(['doc_id'=>'required|exists:documents,id'])['doc_id'];
        $doc   = Document::findOrFail($docId);
        $doc->update(['broadcast_sent'=>true,'broadcast_at'=>now()]);
        return back()->with('success','Broadcast sent.');
    }
}

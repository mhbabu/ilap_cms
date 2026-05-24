<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Student;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $campusId = auth()->user()?->campus_id;
        $q = Lead::query()
            ->when($campusId && !in_array(auth()->user()?->role, ['super_admin','hq_admin']),
                fn($q) => $q->where('campus_id', $campusId))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type,  fn($q) => $q->where('type', $request->type))
            ->when($request->handler_id, fn($q) => $q->where('handler_id', $request->handler_id))
            ->when($request->text, fn($q) => $q->where('name','like',"%{$request->text}%")
                ->orWhere('phone','like',"%{$request->text}%"))
            ->latest();

        $leads       = $q->paginate(20);
        $campusTotal = Lead::whereNotIn('status', ['converted','lost'])->count();
        $handlers    = \App\Models\Handler::active()->get();

        return $this->withOrg('leads.index', compact('leads','campusTotal','handlers'));
    }

    public function create(): View
    {
        $campuses = auth()->user()?->hasRole('super_admin')
            ? Campus::active()->get() : Campus::where('id', auth()->user()?->campus_id)->get();
        $handlers = \App\Models\Handler::active()->get();
        return $this->withOrg('leads.create', compact('campuses','handlers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'required|string',
            'campus_id'      => 'required|exists:campuses,id',
            'source'         => 'required|string|max:255',
            'handler_id'     => 'nullable|exists:handlers,id',
            'notes'          => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        Lead::create($validated);
        return redirect()->route('leads.index')->with('success','Lead created.');
    }

    public function show(Lead $lead): View
    {
        $campusId = auth()->user()?->campus_id;
        if (!$lead->campus_id && !auth()->user()?->hasRole('super_admin')) abort(403);

        $studentPotential = null;
        $leadWith = $lead->load(['campus','handler']);
        return $this->withOrg('leads.show', compact('lead','studentPotential'));
    }

    public function edit(Lead $lead): View
    {
        $campuses = Campus::active()->get();
        $handlers = \App\Models\Handler::active()->get();
        return $this->withOrg('leads.edit', compact('lead','campuses','handlers'));
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'required|string',
            'campus_id'      => 'required|exists:campuses,id',
            'source'         => 'required|string|max:255',
            'handler_id'     => 'nullable|exists:handlers,id',
            'notes'          => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'status'         => 'required|in:new,contacted,qualified,disqualified,converted',
        ]);
        $lead->update($validated);
        return redirect()->route('leads.index')->with('success','Lead updated.');
    }

    public function convert(Request $request, Lead $lead): RedirectResponse
    {
        if ($lead->status === 'converted') return back();

        $student = $lead->convertToStudent([
            'current_step' => 'enrolled',
            'status'       => 'active',
        ]);

        $lead->update(['status' => 'converted']);
        return redirect()->route('students.show', $student)->with('success','Lead converted to student.');
    }

    public function assign(Request $request, Lead $lead): RedirectResponse
    {
        $request->validate(['handler_id' => 'nullable|exists:handlers,id']);
        $lead->update($request->only('handler_id'));
        return back()->with('success','Handler assigned.');
    }

    public function search(Request $request) { return response()->json([]); }
}

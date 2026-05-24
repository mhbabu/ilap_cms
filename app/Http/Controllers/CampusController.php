<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        $q = Campus::query()
            ->when($request->filled('search'), fn($q) => $q->where('name','like',"%{$request->search}%"))
            ->when($request->get('status') === 'active', fn($q) => $q->where('is_active',true))
            ->latest();
        $campuses     = $q->paginate(20);
        $totalCamp    = Campus::count();
        $activeCamp   = Campus::active()->count();
        $totalStudents= Student::count();

        return $this->withOrg('campus.index', compact('campuses','totalCamp','activeCamp','totalStudents'));
    }

    public function create(): View
    {
        $hqAdmins = \App\Models\User::whereHas('roles',fn($q)=>$q->where('name','hq_admin'))->get();
        return $this->withOrg('campus.create', compact('hqAdmins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'manager_user_id'     => 'nullable|exists:users,id',
            'color_primary'       => 'nullable|string',
            'color_secondary'     => 'nullable|string',
        ]);

        Campus::create($validated);

        if (isset($validated['manager_user_id'])) {
            User::find($validated['manager_user_id'])?->update(['campus_id'=>Campus::latest()->first()->id]);
        }

        return redirect()->route('campuses.index')->with('success','Campus created.');
    }

    public function show(Campus $campus): View
    {
        $campus->load(['admin','manager','students','enrollments']);
        $enrollmentSummary = Enrollment::where('campus_id',$campus->id)
            ->selectRaw('status, count(*) as c')->groupBy('status')->pluck('c','status');

        return $this->withOrg('campus.show', compact('campus','enrollmentSummary'));
    }

    public function edit(Campus $campus): View
    {
        $hqAdmins = \App\Models\User::whereHas('roles',fn($q)=>$q->where('name','hq_admin'))->get();
        return $this->withOrg('campus.edit', compact('campus','hqAdmins'));
    }

    public function update(Request $request, Campus $campus): RedirectResponse
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'address'            => 'nullable|string',
            'phone'              => 'nullable|string',
            'manager_user_id'    => 'nullable|exists:users,id',
            'color_primary'      => 'nullable|string',
            'color_secondary'    => 'nullable|string',
        ]);

        $campus->update($validated);

        return redirect()->route('campuses.show',$campus)->with('success','Campus updated.');
    }

    public function destroy(Campus $campus): RedirectResponse
    {
        $campus->delete();
        return redirect()->route('campuses.index')->with('success','Campus deleted.');
    }

    public function tab(Request $request): View
    {
        // Route all tab logic in single method for shared tab structure
        $tab = $request->query('tab', 'enrollments');
        $campus = auth()->user()->campus;

        return match ($tab) {
            'enrollments' => $this->withOrg('campus.tab_enrollments', [
                'enrollments' => Enrollment::where('campus_id',$campus->id)->with(['student','classData','module'])->paginate(30),
                'classes'     => $campus->classes()->with('module')->get(),
            ]),
            'campus-users' => $this->withOrg('campus.tab_users', [
                'users' => $campus->users()->with('roles')->get(),
            ]),
            'payments' => $this->withOrg('campus.tab_payments', [
                'payments' => $campus->payments()->with('payer')->latest()->take(30)->get(),
            ]),
            'tickets' => $this->withOrg('campus.tab_tickets', [
                'tickets' => $campus->tickets()->with('creator')->latest()->take(30)->get(),
            ]),
            default => $this->withOrg('campus.tab_enrollments', [])
        };
    }

    public function uploadDemographic(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx|max:5240',
        ]);
        $request->file('file')->store('demographics/'.auth()->user()->campus_id, 'public');
        return back()->with('success','Demographic data uploaded. Processing may take a few minutes.');
    }
}

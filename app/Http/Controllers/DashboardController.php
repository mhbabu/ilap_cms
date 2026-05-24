<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Student;
use App\Models\Campus;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Ticket;

class DashboardController extends Controller
{
    // ── Authenticated user routed block
    public function __invoke(Request $request): View
    {
        $user   = auth()->user();
        $role   = $user->role;
        $campus = $user->campus;

        // Branch-dashboard table navigator sets main for branched users
        return match($role) {
            'super_admin'   => $this->superAdminDash(),
            'hq_admin'      => $this->hqAdminDash(),
            'campus_admin'  => $this->campusAdminDash(),
            'campus_manager'=> $this->campusManagerDash(),
            'handler'       => $this->handlerDash(),
            'student'       => $this->studentDash(),
            'parent'        => $this->parentDash(),
            default         => $this->passengerDash(),
        };
    }

    public function overview(): View
    {
        $user = auth()->user();

        // Counters for overview metrics
        $activeStudents   = Student::whereIn('current_step', ['enrolled','documents_verified','completed'])->count();
        $paymentPending   = Payment::where('status','pending')->count();
        $openTickets      = Ticket::whereIn('status', ['open','in_progress'])->count();
        $totalLeads       = Lead::where('status','new')->count();

        // Role-specific
        $myTickets = ($user->role === 'handler')
            ? Ticket::where('handler_id', $user->id)->latest()->take(5)->get()
            : Ticket::where('campus_id', $user->campus_id)->latest()->take(5)->get();

        $myStudents = [];
        if ($user->role === 'handler') {
            $myStudents = Student::where('handler_id', $user->id)
                ->whereIn('current_step', ['enrolled','documents_verified','completed'])
                ->take(5)->latest()->get();
        }

        $recentActivities = collect([
            ['icon'=>'📄','text'=>'New student registered','time'=>'2m ago'],
            ['icon'=>'💰','text'=>'Payment approved','time'=>'15m ago'],
            ['icon'=>'🎫','text'=>'Ticket opened','time'=>'1h ago'],
            ['icon'=>'📤','text'=>'Document uploaded','time'=>'2h ago'],
            ['icon'=>'✅','text'=>'Enrollment completed','time'=>'3h ago'],
            ['icon'=>'🔔','text'=>'Deadline reminder sent','time'=>'5h ago'],
        ]);

        return $this->withOrg('dashboard.overview', compact(
            'user', 'role', 'campus',
            'activeStudents', 'paymentPending', 'openTickets', 'totalLeads',
            'myTickets', 'myStudents', 'recentActivities',
        ));
    }

    // ── Server-crashed → redirect to main account page
    public function superAdminDashView(): View   { return $this->superAdminDash(); }
    public function hqAdminDashView(): View      { return $this->hqAdminDash(); }
    public function campusAdminDashView(): View  { return $this->campusAdminDash(); }
    public function passengerDash(): View        { return $this->passengerDash(); }

    private function superAdminDash(): View
    {
        $metrics = [
            'students'    => Student::count(),
            'campuses'    => Campus::count(),
            'payments'    => Payment::count(),
            'revenue'     => Payment::where('status','completed')->sum('amount'),
            'leads'       => Lead::where('status','new')->count(),
            'tickets'     => Ticket::where('status','open')->count(),
            'users'       => User::count(),
        ];
        return $this->withOrg('dashboard.super-admin', compact('metrics'));
    }

    private function hqAdminDash(): View
    {
        $campus = Campus::all();
        return $this->withOrg('dashboard.hq-admin', compact('campus'));
    }

    private function campusAdminDash(): View
    {
        $user   = auth()->user();
        $campus = $user?->campus;
        $students = $campus?->students()->take(5)->latest()->get() ?? collect();

        return $this->withOrg('dashboard.campus-admin', [
            'campus'   => $campus,
            'students' => $students,
        ]);
    }

    private function campusManagerDash(): View
    {
        $user   = auth()->user();
        $campus = $user?->campus;

        return $this->withOrg('dashboard.campus-manager', compact('campus'));
    }

    private function handlerDash(): View
    {
        $user = auth()->user();

        $studentsCount    = Student::where('handler_id',$user->id)->count();
        $tickets          = Ticket::where(function($q) use($user){
                                $q->where('handler_id',$user->id)->orWhereNull('handler_id');
                           })->latest()->take(5)->get();
        $leadsAssigned    = Lead::where('handler_id',$user->id)
            ->whereNotIn('status',['converted','lost'])->count();
        $leadsTotal       = Lead::whereNotIn('status',['converted','lost'])->count();
        $leadsUnassigned  = $leadsTotal - $leadsAssigned;

        return $this->withOrg('dashboard.handler', [
            'studentsCount'    => $studentsCount,
            'tickets'          => $tickets,
            'leadsAssigned'    => $leadsAssigned,
            'leadsTotal'       => $leadsTotal,
            'leadsUnassigned'  => $leadsUnassigned,
        ]);
    }

    private function studentDash(): View
    {
        $user        = auth()->user();
        $student     = Student::where('email', $user->email)->first();
        $payments    = $student ? $student->payments()->latest(5)->get() : collect();
        $enrollments = $student ? $student->enrollments()->with('classData')->get() : collect();
        $documents   = $student ? $student->documents : collect();

        return $this->withOrg('dashboard.student', compact('student','payments','enrollments','documents'));
    }

    private function parentDash(): View { return $this->withOrg('dashboard.parent', []); }
}

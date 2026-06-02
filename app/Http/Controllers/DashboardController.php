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
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user   = auth()->user();
        $role   = $user?->role ?? 'guest';
        $campus = $user?->campus;

        return match($role) {
            'super_admin'   => $this->superAdminDash(),
            'hq_admin'      => $this->hqAdminDash(),
            'campus_admin'  => $this->campusAdminDash(),
            'campus_manager'=> $this->campusManagerDash(),
            'handler'       => $this->handlerDash(),
            'student'       => $this->studentDash(),
            'parent'        => $this->parentDash(),
            default         => $this->overviewDash(),
        };
    }

    public function overview(): View
    {
        $user = auth()->user();
        $role = $user?->role ?? 'user';

        $baseQuery = $this->scopeQuery(Student::query(), $user);
        $activeStudents = (clone $baseQuery)
            ->whereIn('current_step', ['enrolled','documents_verified','completed'])
            ->count();
        $totalStudents = (clone $baseQuery)->count();

        $paymentQuery = $this->scopeQuery(Payment::query(), $user);
        $paymentPending = (clone $paymentQuery)->where('status','pending')->count();
        $paymentCompleted = (clone $paymentQuery)->where('status','completed')->sum('amount');

        $ticketQuery = $this->scopeQuery(Ticket::query(), $user);
        $openTickets = (clone $ticketQuery)->whereIn('status', ['open','in_progress'])->count();

        $leadQuery = $this->scopeQuery(Lead::query(), $user);
        $totalLeads = (clone $leadQuery)->where('status','new')->count();

        $recentActivities = $this->recentActivityFeed();

        $myTickets = collect();
        $myStudents = collect();
        if ($role === 'handler') {
            $myTickets = Ticket::where('handler_id', $user->id)->latest()->take(5)->get();
            $myStudents = Student::where('handler_id', $user->id)
                ->whereIn('current_step', ['enrolled','documents_verified','completed'])
                ->latest()->take(5)->get();
        } else {
            $myTickets = (clone $ticketQuery)->latest()->take(5)->get();
        }

        return $this->withOrg('dashboard.overview', compact(
            'user', 'role', 'campus',
            'activeStudents', 'totalStudents', 'paymentPending', 'paymentCompleted',
            'openTickets', 'totalLeads',
            'myTickets', 'myStudents', 'recentActivities',
        ));
    }

    private function superAdminDash(): View
    {
        $user = auth()->user();

        $metrics = [
            'students'    => Student::count(),
            'campuses'    => Campus::count(),
            'payments'    => Payment::count(),
            'revenue'     => Payment::where('status','completed')->sum('amount'),
            'leads'       => Lead::where('status','new')->count(),
            'tickets'     => Ticket::where('status','open')->count(),
            'users'       => User::count(),
        ];

        $recentUsers = User::latest()->take(5)->get(['name','email','role','created_at']);
        $openTickets = Ticket::whereIn('status', ['open','in_progress'])->latest()->take(5)->get();

        return $this->withOrg('dashboard.super-admin', compact('metrics','recentUsers','openTickets','user'));
    }

    private function hqAdminDash(): View
    {
        $user = auth()->user();
        $campuses = Campus::all();

        $campusData = $campuses->map(function ($c) {
            return [
                'campus'       => $c,
                'students'     => Student::where('campus_id', $c->id)->count(),
                'active'       => Student::where('campus_id', $c->id)
                    ->whereIn('current_step', ['enrolled','documents_verified','completed'])->count(),
                'payments'     => Payment::where('campus_id', $c->id)->count(),
                'pending'      => Payment::where('campus_id', $c->id)->where('status','pending')->count(),
                'tickets'      => Ticket::where('campus_id', $c->id)->whereIn('status', ['open','in_progress'])->count(),
            ];
        });

        return $this->withOrg('dashboard.hq-admin', compact('campuses','campusData','user'));
    }

    private function campusAdminDash(): View
    {
        $user   = auth()->user();
        $campus = $user?->campus;

        if (!$campus) {
            return $this->withOrg('dashboard.campus-admin', [
                'campus'   => null,
                'students' => collect(),
                'stats'    => null,
            ]);
        }

        $studentsQuery = Student::where('campus_id', $campus->id);
        $stats = [
            'total'      => $studentsQuery->count(),
            'active'     => $studentsQuery->whereIn('current_step', ['enrolled','documents_verified','completed'])->count(),
            'payments'   => Payment::where('campus_id', $campus->id)->count(),
            'pending'    => Payment::where('campus_id', $campus->id)->where('status','pending')->count(),
            'tickets'    => Ticket::where('campus_id', $campus->id)->whereIn('status', ['open','in_progress'])->count(),
            'leads'      => Lead::where('campus_id', $campus->id)->where('status','new')->count(),
        ];

        $recentStudents = Student::where('campus_id', $campus->id)->latest()->take(8)->get();
        $recentTickets  = Ticket::where('campus_id', $campus->id)->latest()->take(5)->get();
        $recentPayments = Payment::where('campus_id', $campus->id)->latest()->take(5)->get();

        return $this->withOrg('dashboard.campus-admin', compact(
            'campus','students','stats','recentStudents','recentTickets','recentPayments','user'
        ));
    }

    private function campusManagerDash(): View
    {
        $user   = auth()->user();
        $campus = $user?->campus;

        if (!$campus) {
            return $this->withOrg('dashboard.campus-manager', ['campus' => null]);
        }

        $myStudents = Student::where('campus_id', $campus->id)->count();
        $todayPayments = Payment::where('campus_id', $campus->id)
            ->whereDate('created_at', today())->count();
        $openTickets = Ticket::where('campus_id', $campus->id)
            ->whereIn('status', ['open','in_progress'])->count();
        $pendingLeads = Lead::where('campus_id', $campus->id)->where('status','new')->count();

        $recentStudents = Student::where('campus_id', $campus->id)->latest()->take(5)->get();

        return $this->withOrg('dashboard.campus-manager', compact(
            'campus','myStudents','todayPayments','openTickets','pendingLeads','recentStudents','user'
        ));
    }

    private function handlerDash(): View
    {
        $user = auth()->user();

        $studentsCount  = Student::where('handler_id',$user->id)->count();
        $tickets        = Ticket::where(function($q) use($user){
                            $q->where('handler_id', $user->id)->orWhereNull('handler_id');
                         })->latest()->take(5)->get();
        $leadsAssigned  = Lead::where('handler_id', $user->id)
            ->whereNotIn('status',['converted','lost'])->count();
        $leadsTotal     = Lead::whereNotIn('status',['converted','lost'])->count();
        $leadsUnassigned = $leadsTotal - $leadsAssigned;

        $recentStudents = Student::where('handler_id', $user->id)->latest()->take(5)->get();
        $myLeads = Lead::where('handler_id', $user->id)
            ->whereNotIn('status', ['converted','lost'])
            ->latest()->take(5)->get();

        return $this->withOrg('dashboard.handler', [
            'studentsCount'  => $studentsCount,
            'tickets'        => $tickets,
            'leadsAssigned'  => $leadsAssigned,
            'leadsTotal'     => $leadsTotal,
            'leadsUnassigned'=> $leadsUnassigned,
            'recentStudents' => $recentStudents,
            'myLeads'        => $myLeads,
            'user'           => $user,
        ]);
    }

    private function studentDash(): View
    {
        $user        = auth()->user();
        $student     = Student::where('email', $user->email)->first();
        $payments    = $student ? $student->payments()->latest(5)->get() : collect();
        $enrollments = $student ? $student->enrollments()->with('classData')->get() : collect();
        $documents   = $student ? $student->documents : collect();
        $tickets     = $student ? Ticket::where('student_id', $student->id)->latest()->take(5)->get() : collect();

        return $this->withOrg('dashboard.student', compact(
            'student','payments','enrollments','documents','tickets','user'
        ));
    }

    private function parentDash(): View
    {
        $user = auth()->user();
        $children = Student::where('parent_email', $user->email)->get();

        return $this->withOrg('dashboard.parent', compact('user','children'));
    }

    private function overviewDash(): View
    {
        $user = auth()->user();
        $role = $user?->role ?? 'user';

        $activeStudents = Student::whereIn('current_step', ['enrolled','documents_verified','completed'])->count();
        $paymentPending = Payment::where('status','pending')->count();
        $paymentCompleted = Payment::where('status','completed')->sum('amount');
        $openTickets = Ticket::whereIn('status', ['open','in_progress'])->count();
        $totalLeads = Lead::where('status','new')->count();

        $recentActivities = $this->recentActivityFeed();

        $myTickets = Ticket::where('campus_id', $user?->campus_id)->latest()->take(5)->get();
        $myStudents = Student::where('campus_id', $user?->campus_id)
            ->whereIn('current_step', ['enrolled','documents_verified','completed'])
            ->latest()->take(5)->get();

        return $this->withOrg('dashboard.overview', compact(
            'user', 'role', 'campus',
            'activeStudents', 'totalStudents', 'paymentPending', 'paymentCompleted',
            'openTickets', 'totalLeads',
            'myTickets', 'myStudents', 'recentActivities',
        ));
    }

    private function scopeQuery($query, $user)
    {
        if (!$user) return $query;
        if ($user->hasRole('super_admin') || $user->hasRole('hq_admin')) return $query;
        if ($user->campus_id) return $query->where('campus_id', $user->campus_id);
        return $query->where('id', 0);
    }

    private function recentActivityFeed()
    {
        $activities = collect();

        $recentStudents = Student::latest()->take(3)->get(['name','created_at']);
        foreach ($recentStudents as $s) {
            $activities->push([
                'icon' => '🎓',
                'text' => "New student: {$s->name}",
                'time' => $s->created_at?->diffForHumans() ?? 'recently',
            ]);
        }

        $recentPayments = Payment::where('status','completed')->latest()->take(2)->get(['amount','created_at']);
        foreach ($recentPayments as $p) {
            $activities->push([
                'icon' => '💰',
                'text' => "Payment received: £{$p->amount}",
                'time' => $p->created_at?->diffForHumans() ?? 'recently',
            ]);
        }

        $recentTickets = Ticket::whereIn('status', ['open','in_progress'])->latest()->take(2)->get(['title','created_at']);
        foreach ($recentTickets as $t) {
            $activities->push([
                'icon' => '🎫',
                'text' => "Ticket: {$t->title}",
                'time' => $t->created_at?->diffForHumans() ?? 'recently',
            ]);
        }

        if ($activities->isEmpty()) {
            $activities->push(['icon'=>'📊','text'=>'System ready','time'=>'now']);
        }

        return $activities->take(6);
    }
}

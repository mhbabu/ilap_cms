<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Lead;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Collection;

class DashboardMetricsService
{
    public function getMetricsByRole(string $role, int $campusId = null): array
    {
        return match ($role) {
            'campus_admin'   => $this->forCampusAdmin($campusId),
            'campus_manager' => $this->forCampusManager($campusId),
            'handler'        => $this->forHandler(auth()->id()),
            default          => $this->forSuperAdmin(),
        };
    }

    private function forSuperAdmin(): array
    {
        return [
            'total_students'  => Student::count(),
            'total_campuses'  => \App\Models\Campus::count(),
            'pending_payments'=> \App\Models\Finance::where('status','pending')->count(),
            'open_tickets'    => Ticket::open()->count(),
            'unassigned_leads'=> Lead::unassigned()->count(),
            'revenue'         => \App\Models\Finance::completed()->sum('amount'),
        ];
    }

    private function forCampusAdmin(int|string|null $campusId): array
    {
        if (!$campusId)
            return ['message'=>'No campus assigned'];

        return [
            'students'           => Student::byCampus($campusId)->count(),
            'enrollments'        => \App\Models\Enrollment::byCampus($campusId)->active()->count(),
            'payments_Pending'   => \App\Models\Finance::where('campus_id',$campusId)->where('status','pending')->count(),
            'tickets'            => Ticket::byCampus($campusId)->open()->count(),
            'unread_messages'    => \App\Models\Message::where('receiver_id',auth()->id())->unread()->count(),
        ];
    }

    private function forCampusManager(int|string|null $campusId): array
    {
        return [
            'campus_staff_count' => \App\Models\User::where('campus_id',$campusId)->count(),
            'active_handlers'    => \App\Models\Handler::active()->where('campus_id',$campusId)->count(),
        ];
    }

    private function forHandler(int $handlerId): array
    {
        $studentQuery = Student::query();
        return [
            'my_students'    => (clone $studentQuery)->where('handler_id',$handlerId)->count(),
            'my_active'      => (clone $studentQuery)->where('handler_id',$handlerId)
                            ->whereIn('current_step',['enrolled','documents_verified','completed'])->count(),
            'my_leads'       => Lead::where('handler_id',$handlerId)->whereNotIn('status',['converted','lost'])->count(),
            'my_tickets'     => Ticket::where('handler_id',$handlerId)->whereIn('status',['open','in_progress'])->count(),
        ];
    }
}

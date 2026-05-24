<?php

namespace App\DTOs;

final readonly class DashboardMetrics
{
    public function __construct(
        public int   $totalStudents,
        public int   $pendingPayments,
        public int   $openTickets,
        public int   $campusStudents,
        public ?int  $myTickets  = null,
        public ?int  $myLeads    = null,
    ) {}
}

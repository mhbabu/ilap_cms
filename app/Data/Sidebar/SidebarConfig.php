<?php

namespace App\Data\Sidebar;

readonly class SidebarConfig
{
    public static function items(): array
    {
        $section = static fn (string $label, array $children) => [
            'section' => $label,
            'children' => $children,
        ];

        return [
            $section('Main', [
                new SidebarItem('fa-gauge-high', 'Dashboard', 'dashboard', null),
                new SidebarItem('fa-user-graduate', 'Students', 'students.index', 'view students'),
                new SidebarItem('fa-user-plus', 'Leads', 'leads.index', 'view leads'),
                new SidebarItem('fa-book', 'Courses', 'modules.index', 'view modules'),
            ]),
            $section('Teaching', [
                new SidebarItem('fa-users', 'Classes', 'classes.index', 'view classes'),
                new SidebarItem('fa-film', 'Videos', 'videos.index', 'view videos'),
                new SidebarItem('fa-id-card', 'Enrollments', 'enrollments.index', 'view enrollments'),
            ]),
            $section('Communication', [
                new SidebarItem('fa-envelope', 'Messages', 'messages.inbox', 'view messages'),
            ]),
            $section('Management', [
                new SidebarItem('fa-chart-line', 'Finance', 'finance.index', 'view finance'),
                new SidebarItem('fa-file-lines', 'Documents', 'documents.index', 'view documents'),
                new SidebarItem('fa-ticket', 'Tickets', 'tickets.index', 'view tickets'),
                new SidebarItem('fa-building', 'Campuses', 'campuses.index', 'view campuses'),
            ]),
            $section('System', [
                new SidebarItem('fa-chart-pie', 'Reports', 'reports.index', 'view reports'),
                new SidebarItem('fa-gear', 'Settings', 'settings.index', 'view settings'),
            ]),
        ];
    }
}

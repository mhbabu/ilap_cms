<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('ilap:reset-demo', function () {
    $this->warn('Demo reset — implement with proper logic.');
})->purpose('Reset demo data');

Artisan::command('ilap:set-role', function ($userId, $role) {
    $user = \App\Models\User::findOrFail($userId);
    $user->syncRoles([$role]);
    $this->info("Assigned $role to {$user->name}.");
})->purpose('Set role for a user');

Artisan::command('ilap:gradebook {classId}', function ($classId) {
    $class = \App\Models\ClassRoom::findOrFail($classId);
    $this->table(['Student', 'Topic', 'Grade', 'Attendance'], $class->records->map(function ($r) {
        return [$r->student?->name, $r->topic, $r->grade, $r->attendance ? 'Yes' : 'No'];
    }));
})->purpose('Print gradebook for a class');

Artisan::command('ilap:send-reminders', function () {
    $this->info('Enrollment demo reminder sent.');
})->purpose('Send enrollment deadline reminders');

Artisan::command('ilap:seed', function () {
    $this->call(\Illuminate\Database\Console\Seeds\SeedCommand::class);
})->purpose('Seed data');

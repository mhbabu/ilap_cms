<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Document::class  => \App\Policies\DocumentPolicy::class,
        \App\Models\Ticket::class    => \App\Policies\TicketPolicy::class,
        \App\Models\Payment::class   => \App\Policies\PaymentPolicy::class,
        \App\Models\Student::class   => \App\Policies\StudentPolicy::class,
    ];

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user?->hasRole('super_admin')) return true;
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verify your iLAP email address')
                ->line('Please verify your email address by clicking the button below.')
                ->action('Verify Email Address', $url)
                ->line('This link will expire in 60 minutes.');
        });
    }
}

<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to iLAP CMS')
            ->line('Your account has been created.')
            ->line('Role: '.$notifiable->getRoleNames()->first())
            ->action('Login to iLAP', url('/login'));
    }
}

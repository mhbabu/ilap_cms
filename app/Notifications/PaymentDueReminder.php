<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentDueReminder extends Notification
{
    public function __construct(public array $data = []) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Due Reminder — iLAP CMS')
            ->line('Your payment is due soon.')
            ->line('Amount: '.($this->data['amount'] ?? '—'))
            ->line('Due Date: '.($this->data['due_date'] ?? '—'))
            ->line('Campus: '.($this->data['campus'] ?? '—'));
    }
}

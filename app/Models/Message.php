<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'subject', 'body', 'type', 'is_read', 'sent_at', 'template_id'];

    protected $casts = ['is_read' => 'boolean', 'sent_at' => 'datetime'];

    protected $dates = ['sent_at', 'read_at'];

    public function sender()   { return $this->belongsTo(\App\Models\User::class, 'sender_id'); }
    public function receiver() { return $this->belongsTo(\App\Models\User::class, 'receiver_id'); }
    public function template() { return $this->belongsTo(EmailTemplate::class, 'template_id'); }
    public function ticket()   { return $this->belongsTo(Ticket::class); }

    public function scopeUnread($q) { return $q->where('is_read', false); }
    public function scopeByType($q, $type) { return $q->where('type', $type); }
    public function scopeInbox($q) { return $q->where('receiver_id', auth()->id()); }
    public function scopeSent($q)  { return $q->where('sender_id', auth()->id()); }

    protected static function booted(): void
    {
        static::creating(function (Message $message) {
            if (!$message->sent_at) $message->sent_at = now();
        });
    }
}

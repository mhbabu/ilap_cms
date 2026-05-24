<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', 'title', 'description', 'status',
        'priority', 'created_by', 'assigned_to', 'campus_id',
        'type', 'handler_id', 'parent_ticket_id',
    ];

    protected $hidden = [];

    public function creator()   { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
    public function assigned()  { return $this->belongsTo(\App\Models\User::class, 'assigned_to'); }
    public function campus()    { return $this->belongsTo(Campus::class); }
    public function handler()   { return $this->belongsTo(Handler::class, 'handler_id'); }
    public function messages()  { return $this->hasMany(TicketMessage::class); }
    public function parent()    { return $this->belongsTo(self::class, 'parent_ticket_id'); }
    public function children()  { return $this->hasMany(self::class, 'parent_ticket_id'); }

    protected static function booted(): void
    {
        static::creating(function (Ticket $ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT-'.strtoupper(substr(uniqid(), -8));
            }
            $ticket->status     = $ticket->status     ?: 'open';
            $ticket->priority   = $ticket->priority   ?: 'medium';
            $ticket->created_by = $ticket->created_by ?: auth()->id();
        });
    }

    public function isOpen()        { return $this->status === 'open'; }
    public function isInProgress()  { return $this->status === 'in_progress'; }
    public function isClosed()      { return $this->status === 'closed'; }
    public function isResolved()    { return $this->status === 'resolved'; }

    public function scopeOpen($q)      { return $q->where('status', 'open'); }
    public function scopeByCampus($q, $campusId){ return $q->where('campus_id', $campusId); }
    public function scopeByType($q, $type)  { return $q->where('type', $type); }
}

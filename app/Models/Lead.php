<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'campus_id', 'source',
        'handler_id', 'notes', 'follow_up_date', 'is_flag', 'status',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'is_flag'        => 'boolean',
    ];

    // ── Relationships
    public function campus()  { return $this->belongsTo(Campus::class); }
    public function handler() { return $this->belongsTo(User::class, 'handler_id'); }

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            $lead->status = $lead->status ?: 'new';
        });
    }

    // ── Scopes
    public function scopeUnassigned($q) { return $q->whereNull('handler_id'); }
    public function scopeFlagged($q)   { return $q->where('is_flag', true); }
    public function scopePending($q)   { return $q->whereIn('status', ['new', 'contacted']); }
    public function scopeConverted($q){ return $q->where('status', 'converted'); }

    public function convertToStudent(array $data): Student
    {
        return Student::create(array_merge([
            'user_id'     => ($this->handler) ? $this->handler->user_id : null,
            'campus_id'   => $this->campus_id,
            'handler_id'  => $this->handler_id,
            'status'      => 'active',
            'current_step'=> 'enrolled',
            'phone'       => $this->phone,
            'email'       => $this->email,
            'address'     => $this->notes ?? '',
            'lead_source' => $this->source,
        ], $data));
    }

    public function markContacted()
    {
        $this->status = 'contacted';
        $this->save();
    }
}

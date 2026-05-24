<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer_id', 'campus_id', 'student_id', 'amount',
        'type', 'status', 'account_name', 'bank_name',
        'account_number', 'transaction_ref', 'notes',
        'initiated_by', 'approved_by', 'approved_at',
        'installment_of', 'parent_payment_id', 'is_hq_visible',
    ];

    protected $casts = [
        'amount'              => 'float',
        'approved_at'         => 'datetime',
        'is_hq_visible'       => 'boolean',
        'parent_payment_id'   => 'integer',
    ];

    // ── Relationships
    public function payer()     { return $this->belongsTo(Student::class, 'payer_id'); }
    public function campus()    { return $this->belongsTo(Campus::class); }
    public function student()   { return $this->belongsTo(Student::class); }
    public function initiator() { return $this->belongsTo(\App\Models\User::class, 'initiated_by'); }
    public function approver()  { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }

    public function isPending()   { return $this->status === 'pending'; }
    public function isApproved()  { return $this->status === 'approved'; }
    public function isRejected()  { return $this->status === 'rejected'; }
    public function isCompleted() { return $this->status === 'completed'; }

    public function scopePending($q)     { return $q->where('status', 'pending'); }
    public function scopeCompleted($q)   { return $q->where('status', 'completed'); }
    public function scopeByCampus($q, $campusId){ return $q->where('campus_id', $campusId); }
    public function scopeHqVisible($q)   { return $q->where('is_hq_visible', true); }

    public function markApproved($approverId)
    {
        $this->status          = 'approved';
        $this->approved_by     = $approverId;
        $this->approved_at     = now();
        $this->save();
    }

    public function buildInvoiceHtml(): string
    {
        return view('components.invoice', ['payment' => $this])->render();
    }
}

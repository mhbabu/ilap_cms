<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'campus_id', 'handler_id', 'enrollment_date',
        'current_step', 'status', 'lead_source', 'ielts_score',
        'passport_number', 'qualification', 'unique_id',
        'enrollment_type', 'is_pro', 'date_of_birth', 'phone',
        'address', 'photo', 'parent_phone', 'parent_email',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'date_of_birth'   => 'date',
        'is_pro'          => 'boolean',
        'ielts_score'     => 'float',
    ];

    // ── Relationships
    public function user()     { return $this->belongsTo(User::class, 'user_id'); }
    public function campus()   { return $this->belongsTo(Campus::class); }
    public function handler()  { return $this->belongsTo(User::class, 'handler_id'); }
    public function enrollments(){ return $this->hasMany(Enrollment::class); }
    public function courseEnrollments() { return $this->hasMany(CourseEnrollment::class); }
    public function payments()  { return $this->hasMany(Payment::class); }
    public function documents() { return $this->hasMany(Document::class); }
    public function tickets()   { return $this->hasMany(Ticket::class); }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments');
    }

    // ── Auto-generate unique_id
    protected static function booted(): void
    {
        static::created(function (Student $student) {
            if (!$student->unique_id) {
                $student->update(['unique_id' => 'STU' . strtoupper(substr(uniqid(), -6))]);
            }
        });
    }

    public function canTransitionTo(string $next): bool
    {
        $flow = ['registered', 'payment_pending', 'enrolled', 'documents_verified', 'completed'];
        return array_search($next, $flow, true) > array_search($this->current_step, $flow, true);
    }

    public function advanceStatus()
    {
        $flow = ['registered', 'payment_pending', 'enrolled', 'documents_verified', 'completed'];
        $idx  = array_search($this->current_step, $flow, true);
        if ($idx !== false && $idx < count($flow) - 1) {
            $this->current_step = $flow[$idx + 1];
            $this->save();
        }
    }

    public function scopeLead($q)     { return $q->whereIn('current_step', ['registered', 'payment_pending']); }
    public function scopeEnrolled($q) { return $q->whereIn('current_step', ['enrolled', 'documents_verified', 'completed']); }
    public function scopeByCampus($q, $campusId) { return $q->where('campus_id', $campusId); }
    public function scopeByHandler($q, $handlerId){ return $q->where('handler_id', $handlerId); }
    public function scopeByStatus($q, $status)    { return $q->where('current_step', $status); }
}

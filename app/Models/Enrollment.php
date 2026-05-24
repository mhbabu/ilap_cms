<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'campus_id', 'class_id', 'module_id',
        'enrollment_date', 'status', 'notes', 'approved_by_hq',
        'payment_amount', 'start_date', 'end_date',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'start_date'      => 'date',
        'end_date'        => 'date',
        'approved_by_hq'  => 'boolean',
        'payment_amount'  => 'float',
    ];

    // ── Relationships
    public function student()    { return $this->belongsTo(Student::class); }
    public function campus()     { return $this->belongsTo(Campus::class); }
    public function classData()  { return $this->belongsTo(ClassRoom::class, 'class_id'); }
    public function module()     { return $this->belongsTo(Module::class); }

    protected static function booted(): void
    {
        static::saving(function (Enrollment $enrollment) {
            if ($enrollment->isDirty('status') && $enrollment->student) {
                $enrollment->student->current_step = $enrollment->status;
                $enrollment->student->save();
            }
        });
    }

    public function scopeActive($q) { return $q->where('status', 'enrolled'); }
    public function scopeByCampus($q, $campusId){ return $q->where('campus_id', $campusId); }
    public function scopeByStudent($q, $studentId){ return $q->where('student_id', $studentId); }
}

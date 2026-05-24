<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id', 'student_id', 'teacher_id', 'module_id',
        'topic', 'grade', 'attendance', 'notes', 'record_date',
        'auto_transcript', 'transcript_generated', 'institution_name',
        'certificate_url', 'soft_copy_url',
    ];

    protected $casts = [
        'record_date'            => 'date',
        'grade'                  => 'float',
        'attendance'             => 'boolean',
        'transcript_generated'   => 'boolean',
    ];

    public function classData() { return $this->belongsTo(ClassRoom::class, 'class_id'); }
    public function student()   { return $this->belongsTo(Student::class); }
    public function teacher()   { return $this->belongsTo(\App\Models\User::class, 'teacher_id'); }
    public function module()    { return $this->belongsTo(Module::class); }

    public function generateTranscript()
    {
        $this->auto_transcript = sprintf(
            'Transcript — Class: %s | Student: %s | Grade: %.1f | Date: %s',
            $this->classData?->name ?? '—',
            $this->student?->name ?? '—',
            $this->grade ?? 0.0,
            $this->record_date,
        );
        $this->transcript_generated = true;
        $this->save();
        return $this->auto_transcript;
    }
}

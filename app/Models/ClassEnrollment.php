<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $fillable = ['class_id', 'student_id'];

    public function class()   { return $this->belongsTo(ClassRoom::class); }
    public function student() { return $this->belongsTo(Student::class); }
}

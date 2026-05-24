<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'campus_id', 'module_id', 'teacher_id', 'is_active'];

    protected $hidden = [];

    protected $casts = ['is_active' => 'boolean'];

    public function campus()      { return $this->belongsTo(Campus::class); }
    public function module()      { return $this->belongsTo(Module::class); }
    public function teacher()     { return $this->belongsTo(\App\Models\User::class, 'teacher_id'); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function records()     { return $this->hasMany(ClassRecord::class); }
    public function students()    { return $this->belongsToMany(Student::class, 'class_enrollments'); }

    public function scopeActive($q) { return $q->where('is_active', true); }
}

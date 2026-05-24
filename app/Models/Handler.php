<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Handler extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'user_id', 'campus_id', 'is_active'];

    protected $hidden = [];

    protected $casts = ['is_active' => 'boolean'];

    public function user()     { return $this->belongsTo(\App\Models\User::class); }
    public function campus()   { return $this->belongsTo(Campus::class); }
    public function students() { return $this->hasMany(\App\Models\Student::class, 'handler_id'); }
    public function leads()    { return $this->hasMany(\App\Models\Lead::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function totalStudents()
    {
        return $this->hasMany(\App\Models\Student::class, 'handler_id')->count();
    }
}

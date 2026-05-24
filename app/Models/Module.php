<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'is_active'];

    protected $hidden = [];

    protected $casts = ['is_active' => 'boolean'];

    public function classes()     { return $this->hasMany(ClassRoom::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function records()     { return $this->hasMany(ClassRecord::class); }
    public function affiliates()  { return $this->hasMany(ModuleAffiliate::class, 'module_id'); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function isAffiliated(): bool
    {
        return $this->affiliates()->where('is_affiliated', true)->exists();
    }
}

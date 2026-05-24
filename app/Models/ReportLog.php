<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportLog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'data', 'generated_by', 'format', 'generated_at'];

    protected $casts = ['generated_at' => 'datetime', 'data' => 'array'];

    public function generator() { return $this->belongsTo(\App\Models\User::class, 'generated_by'); }

    public function scopeByType($q, $type) { return $q->where('type', $type); }
    public function scopeRecent($q, $days = 30) { return $q->where('generated_at', '>=', now()->subDays($days)); }
}

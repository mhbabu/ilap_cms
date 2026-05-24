<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemDocumentTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'file_path', 'uploaded_by', 'is_active', 'description'];

    public function uploader() { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }

    public function scopeActive($q) { return $q->where('is_active', true); }
}

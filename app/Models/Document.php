<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'filename', 'original_name',
        'path', 'mime', 'size', 'uploaded_by', 'campus_id',
        'student_id', 'type', 'is_guide_document', 'is_template',
        'template_file_path', 'broadcast_sent', 'broadcast_at',
        'ce_requested_at', 'ce_status',
    ];

    protected $casts = [
        'size'          => 'integer',
        'is_guide_document' => 'boolean',
        'is_template'   => 'boolean',
        'broadcast_sent'=> 'boolean',
        'ce_requested_at' => 'datetime',
        'ce_status'     => 'string',
    ];

    public function uploader()  { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }
    public function campus()    { return $this->belongsTo(Campus::class); }
    public function student()   { return $this->belongsTo(Student::class); }
    public function approvals() { return $this->hasMany(\App\Models\DocumentApproval::class); }

    protected static function booted(): void
    {
        static::creating(function (Document $doc) {
            if (!$doc->uploaded_by && auth()->id()) $doc->uploaded_by = auth()->id();
        });
    }

    public function isPdf()          { return str_contains($this->mime, 'pdf'); }
    public function isWord()         { return str_contains($this->mime, 'word') || str_contains($this->mime, 'document'); }
    public function isImage()        { return str_contains($this->mime, 'image'); }
    public function isExcel()        { return str_contains($this->mime, 'spreadsheet') || str_contains($this->mime, 'excel'); }

    public function getSizeFormattedAttribute()
    {
        $size = $this->size;
        if ($size < 1024)   return $size . ' B';
        if ($size < 1048576) return round($size / 1024, 1) . ' KB';
        return round($size / 1048576, 1) . ' MB';
    }

    public function scopeGuideDocs($q)    { return $q->where('is_guide_document', true); }
    public function scopeByCampus($q, $campusId) { return $q->where('campus_id', $campusId); }
    public function scopeByType($q, $type) { return $q->where('type', $type); }
}

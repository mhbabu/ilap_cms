<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentApproval extends Model
{
    protected $fillable = ['document_id', 'reviewer_id', 'status', 'comments', 'completed_at'];

    protected $casts = ['completed_at' => 'datetime'];

    public function document() { return $this->belongsTo(\App\Models\Document::class); }
    public function reviewer() { return $this->belongsTo(\App\Models\User::class, 'reviewer_id'); }

    public function isPending()  { return $this->status === 'pending'; }
    public function isApproved() { return $this->status === 'approved'; }
    public function isRejected() { return $this->status === 'rejected'; }
}

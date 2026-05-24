<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'subject', 'body_html', 'body_text', 'is_active', 'design_theme'];

    public function scopeActive($q)     { return $q->where('is_active', true); }
    public function scopeByType($q, $type) { return $q->where('type', $type); }

    public function render(array $data = []): string
    {
        return str_replace(array_keys($data), array_values($data), $this->body_html ?: $this->body_text);
    }
}

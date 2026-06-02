<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'position',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function videos()
    {
        return $this->hasMany(ClassRecord::class);
    }
}
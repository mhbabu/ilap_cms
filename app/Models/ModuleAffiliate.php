<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleAffiliate extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'provider_name', 'is_affiliated'];

    protected $casts = ['is_affiliated' => 'boolean'];

    public function module() { return $this->belongsTo(Module::class); }
}

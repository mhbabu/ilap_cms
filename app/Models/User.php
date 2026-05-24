<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasUuids;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role',
        'campus_id', 'is_active', 'is_pro', 'unique_id',
        'parent_id', 'nid_number', 'photo',
        'address', 'date_of_birth', 'last_login_at',
        'forced_login', 'email_verified_at', 'remember_token',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'date_of_birth'     => 'date',
        'is_active'         => 'boolean',
        'is_pro'            => 'boolean',
        'forced_login'      => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    // ── Campus Relationships
    public function campus()      { return $this->belongsTo(Campus::class, 'campus_id'); }

    // ── Handler (parent handler)
    public function handler()     { return $this->belongsTo(self::class, 'parent_id'); }

    // ── Children / subordinates
    public function handledStudents() { return $this->hasMany(Student::class, 'handler_id'); }

    // ── Auth / user identity
    public function studentProfile() { return $this->hasOne(Student::class); }

    protected static function booted(): void
    {
        static::created(fn(User $user) => ($user ? $user : null) && $user->update([
            'unique_id' => 'USR' . strtoupper(substr(uniqid(), -6)),
        ]));
    }
}

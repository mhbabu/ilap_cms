<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'address', 'city', 'phone',
        'email', 'unique_code', 'is_active', 'hq_id',
        'payment_account_name', 'payment_bank_name',
        'payment_account_number', 'payment_instructions',
        'color_primary', 'color_secondary', 'logo',
        'opening_hours', 'manager_user_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships
    public function admin()      { return $this->hasOne(User::class, 'campus_id')->where('role', 'campus_admin'); }
    public function manager()    { return $this->hasOne(User::class, 'campus_id')->where('role', 'campus_manager'); }
    public function users()      { return $this->hasMany(User::class); }
    public function students()   { return $this->hasMany(Student::class); }
    public function classes()    { return $this->hasMany(ClassRoom::class); }
    public function enrollments(){ return $this->hasMany(Enrollment::class); }
    public function payments()   { return $this->hasMany(Payment::class); }
    public function tickets()    { return $this->hasMany(Ticket::class); }
    public function documents()  { return $this->hasMany(Document::class); }
    public function leads()      { return $this->hasMany(Lead::class); }
    public function modules()    { return $this->hasMany(Module::class); }

    protected static function booted(): void
    {
        static::creating(function (Campus $campus) {
            if (empty($campus->unique_code))
                $campus->unique_code = 'CP' . strtoupper(substr(uniqid(), -6));
        });
    }

    // ── Scopes / Helpers
    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getPrimaryColorAttribute()
    {
        return $this->attributes['color_primary'] ?? '#1e40af'; // blue-700 default
    }

    public function getSecondaryColorAttribute()
    {
        return $this->attributes['color_secondary'] ?? '#3b82f6'; // blue-500 default
    }

    public function activeStudentsCount()
    {
        return $this->hasMany(Student::class)
            ->whereIn('current_step', ['enrolled', 'documents_verified', 'completed'])
            ->count();
    }

    public function pendingPaymentsCount()
    {
        return $this->hasMany(Payment::class)
            ->where('status', 'pending')
            ->count();
    }

    public function openTicketsCount()
    {
        return $this->hasMany(Ticket::class)
            ->whereIn('status', ['open', 'in_progress'])
            ->count();
    }
}

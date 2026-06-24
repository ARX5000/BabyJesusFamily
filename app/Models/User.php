<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Classes assigned to this teacher.
     */
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_class', 'teacher_id', 'class_id');
    }

    /**
     * Students created by this user.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'created_by');
    }

    /**
     * Audit logs by this user.
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}

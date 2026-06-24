<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'national_id',
        'phone',
        'parent_name',
        'parent_phone',
        'address',
        'birth_date',
        'gender',
        'class_id',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    /**
     * Class this student belongs to.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Activities this student participates in.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'student_activity')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    /**
     * Teacher/admin who created this student.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'قيد الانتظار',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            default    => $this->status,
        };
    }

    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'male' ? 'ذكر' : 'أنثى';
    }
}

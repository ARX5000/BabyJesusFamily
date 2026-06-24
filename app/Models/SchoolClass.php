<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Students in this class.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Teachers assigned to this class.
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_class', 'class_id', 'teacher_id');
    }

    /**
     * Count of approved students.
     */
    public function approvedStudentsCount(): int
    {
        return $this->students()->where('status', 'approved')->count();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'    => Student::count(),
            'approved_students' => Student::where('status', 'approved')->count(),
            'pending_students'  => Student::where('status', 'pending')->count(),
            'rejected_students' => Student::where('status', 'rejected')->count(),
            'total_teachers'    => User::role('teacher')->count(),
            'total_classes'     => SchoolClass::count(),
            'total_activities'  => Activity::count(),
        ];

        $recentStudents = Student::with(['schoolClass', 'creator'])
            ->latest()
            ->limit(10)
            ->get();

        $pendingStudents = Student::with(['schoolClass', 'creator'])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        // Chart data: students per class
        $studentsPerClass = SchoolClass::withCount('students')->get()
            ->map(fn($c) => ['name' => $c->name, 'count' => $c->students_count]);

        // Chart data: students per activity
        $studentsPerActivity = Activity::withCount('students')->get()
            ->map(fn($a) => ['name' => $a->name, 'count' => $a->students_count]);

        return view('admin.dashboard', compact(
            'stats', 'recentStudents', 'pendingStudents',
            'studentsPerClass', 'studentsPerActivity'
        ));
    }
}

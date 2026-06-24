<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $classIds = $teacher->classes->pluck('id');

        $stats = [
            'total_students'   => Student::whereIn('class_id', $classIds)->count(),
            'pending_students' => Student::whereIn('class_id', $classIds)->where('status', 'pending')->count(),
            'classes_count'    => $classIds->count(),
        ];

        $recentStudents = Student::with('schoolClass')
            ->whereIn('class_id', $classIds)
            ->where('created_by', $teacher->id)
            ->latest()
            ->limit(5)
            ->get();

        $assignedClasses = $teacher->classes()->withCount('students')->get();

        return view('teacher.dashboard', compact('stats', 'recentStudents', 'assignedClasses'));
    }
}

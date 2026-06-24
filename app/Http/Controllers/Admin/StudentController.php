<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['schoolClass', 'creator', 'activities']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('activity_id')) {
            $query->whereHas('activities', fn($q) => $q->where('activities.id', $request->activity_id));
        }

        $students   = $query->latest()->paginate(20)->withQueryString();
        $classes    = SchoolClass::orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes', 'activities'));
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'creator', 'activities']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes    = SchoolClass::orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        $student->load('activities');
        return view('admin.students.edit', compact('student', 'classes', 'activities'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|min:3|max:200',
            'national_id'  => 'required|digits:14|unique:students,national_id,' . $student->id,
            'phone'        => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'parent_name'  => 'required|string|min:3|max:200',
            'parent_phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'address'      => 'nullable|string|max:500',
            'birth_date'   => 'nullable|date|before:today',
            'gender'       => 'required|in:male,female',
            'class_id'     => 'required|exists:school_classes,id',
            'status'       => 'required|in:pending,approved,rejected',
            'activities'   => 'nullable|array',
            'activities.*' => 'exists:activities,id',
        ]);

        $student->update(collect($data)->except('activities')->toArray());

        // Sync activities
        $student->activities()->sync($request->activities ?? []);

        AuditLog::log('تعديل طالب', 'students', $student->id, "تم تعديل بيانات: {$student->full_name}");

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'تم تعديل بيانات الطالب بنجاح.');
    }

    public function destroy(Student $student)
    {
        $name = $student->full_name;
        $student->delete();

        AuditLog::log('حذف طالب', 'students', $student->id, "تم حذف: {$name}");

        return redirect()->route('admin.students.index')
            ->with('success', 'تم حذف الطالب بنجاح.');
    }

    public function approve(Student $student)
    {
        $student->update(['status' => 'approved']);

        AuditLog::log('قبول طالب', 'students', $student->id, "تم قبول: {$student->full_name}");

        return back()->with('success', "تم قبول الطالب {$student->full_name} بنجاح.");
    }

    public function reject(Student $student)
    {
        $student->update(['status' => 'rejected']);

        AuditLog::log('رفض طالب', 'students', $student->id, "تم رفض: {$student->full_name}");

        return back()->with('success', "تم رفض الطالب {$student->full_name}.");
    }

    public function pending()
    {
        $students = Student::with(['schoolClass', 'creator'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.students.pending', compact('students'));
    }
}

<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected function getTeacherClassIds(): \Illuminate\Support\Collection
    {
        return auth()->user()->classes->pluck('id');
    }

    public function index(Request $request)
    {
        $classIds = $this->getTeacherClassIds();

        $query = Student::with(['schoolClass', 'activities'])
            ->whereIn('class_id', $classIds);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id') && $classIds->contains($request->class_id)) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $classes  = auth()->user()->classes()->orderBy('name')->get();

        return view('teacher.students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes    = auth()->user()->classes()->orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        return view('teacher.students.create', compact('classes', 'activities'));
    }

    public function store(Request $request)
    {
        $classIds = $this->getTeacherClassIds();

        $data = $request->validate([
            'full_name'    => 'required|string|min:3|max:200',
            'national_id'  => 'required|digits:14|unique:students,national_id',
            'phone'        => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'parent_name'  => 'required|string|min:3|max:200',
            'parent_phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'address'      => 'nullable|string|max:500',
            'birth_date'   => 'nullable|date|before:today',
            'gender'       => 'required|in:male,female',
            'class_id'     => ['required', 'exists:school_classes,id', function ($attr, $val, $fail) use ($classIds) {
                if (!$classIds->contains($val)) {
                    $fail('لا تملك صلاحية إضافة طلاب لهذا الفصل.');
                }
            }],
            'activities'   => 'nullable|array',
            'activities.*' => 'exists:activities,id',
        ]);

        $student = Student::create(array_merge(
            collect($data)->except('activities')->toArray(),
            ['status' => 'pending', 'created_by' => auth()->id()]
        ));

        // Sync activities
        if (!empty($data['activities'])) {
            $student->activities()->sync($data['activities']);
        }

        AuditLog::log('إضافة طالب', 'students', $student->id, "تم إضافة طالب: {$student->full_name}");

        return redirect()->route('teacher.students.index')
            ->with('success', 'تم إضافة الطالب بنجاح. في انتظار موافقة المسؤول.');
    }

    public function show(Student $student)
    {
        $this->authorizeStudentAccess($student);
        $student->load(['schoolClass', 'activities', 'creator']);
        return view('teacher.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->authorizeStudentAccess($student);
        $classes    = auth()->user()->classes()->orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        $student->load('activities');
        return view('teacher.students.edit', compact('student', 'classes', 'activities'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorizeStudentAccess($student);
        $classIds = $this->getTeacherClassIds();

        $data = $request->validate([
            'full_name'    => 'required|string|min:3|max:200',
            'national_id'  => 'required|digits:14|unique:students,national_id,' . $student->id,
            'phone'        => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'parent_name'  => 'required|string|min:3|max:200',
            'parent_phone' => ['required', 'regex:/^(010|011|012|015)\d{8}$/'],
            'address'      => 'nullable|string|max:500',
            'birth_date'   => 'nullable|date|before:today',
            'gender'       => 'required|in:male,female',
            'class_id'     => ['required', 'exists:school_classes,id', function ($attr, $val, $fail) use ($classIds) {
                if (!$classIds->contains($val)) {
                    $fail('لا تملك صلاحية نقل الطالب لهذا الفصل.');
                }
            }],
            'activities'   => 'nullable|array',
            'activities.*' => 'exists:activities,id',
        ]);

        $student->update(collect($data)->except('activities')->toArray());
        $student->activities()->sync($data['activities'] ?? []);

        AuditLog::log('تعديل طالب', 'students', $student->id, "تم تعديل: {$student->full_name}");

        return redirect()->route('teacher.students.show', $student)
            ->with('success', 'تم تعديل بيانات الطالب بنجاح.');
    }

    /**
     * Ensure teacher only accesses students from their classes.
     */
    protected function authorizeStudentAccess(Student $student): void
    {
        $classIds = $this->getTeacherClassIds();

        if (!$classIds->contains($student->class_id)) {
            abort(403, 'ليس لديك صلاحية الوصول لهذا الطالب.');
        }
    }
}

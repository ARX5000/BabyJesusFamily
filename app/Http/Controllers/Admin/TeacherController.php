<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('teacher')->with('classes');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $teachers = $query->latest()->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('admin.teachers.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|min:3|max:200',
            'email'    => 'required|email|unique:users,email',
            'phone'    => ['nullable', 'regex:/^(010|011|012|015)\d{8}$/'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'classes'  => 'nullable|array',
            'classes.*'=> 'exists:school_classes,id',
        ]);

        $teacher = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'status'   => 'active',
        ]);

        $teacher->assignRole('teacher');

        // Assign classes
        if (!empty($data['classes'])) {
            $teacher->classes()->sync($data['classes']);
        }

        AuditLog::log('إنشاء معلم', 'users', $teacher->id, "تم إنشاء حساب المعلم: {$teacher->name}");

        return redirect()->route('admin.teachers.index')
            ->with('success', 'تم إنشاء حساب المعلم بنجاح.');
    }

    public function edit(User $teacher)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $teacher->load('classes');
        return view('admin.teachers.edit', compact('teacher', 'classes'));
    }

    public function update(Request $request, User $teacher)
    {
        $data = $request->validate([
            'name'     => 'required|string|min:3|max:200',
            'email'    => 'required|email|unique:users,email,' . $teacher->id,
            'phone'    => ['nullable', 'regex:/^(010|011|012|015)\d{8}$/'],
            'status'   => 'required|in:active,inactive',
            'classes'  => 'nullable|array',
            'classes.*'=> 'exists:school_classes,id',
        ]);

        $teacher->update([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'phone'  => $data['phone'] ?? null,
            'status' => $data['status'],
        ]);

        $teacher->classes()->sync($data['classes'] ?? []);

        AuditLog::log('تعديل معلم', 'users', $teacher->id, "تم تعديل بيانات المعلم: {$teacher->name}");

        return redirect()->route('admin.teachers.index')
            ->with('success', 'تم تعديل بيانات المعلم بنجاح.');
    }

    public function resetPassword(Request $request, User $teacher)
    {
        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $teacher->update(['password' => Hash::make($data['password'])]);

        AuditLog::log('إعادة تعيين كلمة مرور', 'users', $teacher->id, "تم تغيير كلمة مرور المعلم: {$teacher->name}");

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }

    public function toggleStatus(User $teacher)
    {
        $teacher->update([
            'status' => $teacher->status === 'active' ? 'inactive' : 'active',
        ]);

        $statusLabel = $teacher->status === 'active' ? 'تفعيل' : 'تعطيل';
        AuditLog::log("{$statusLabel} حساب معلم", 'users', $teacher->id, "{$statusLabel} حساب: {$teacher->name}");

        return back()->with('success', "تم {$statusLabel} حساب المعلم بنجاح.");
    }
}

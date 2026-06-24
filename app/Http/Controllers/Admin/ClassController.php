<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount(['students', 'teachers'])->latest()->paginate(15);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:school_classes,name',
            'description' => 'nullable|string|max:500',
        ]);

        $class = SchoolClass::create($data);

        AuditLog::log('إنشاء فصل', 'school_classes', $class->id, "تم إنشاء الفصل: {$class->name}");

        return redirect()->route('admin.classes.index')
            ->with('success', 'تم إنشاء الفصل بنجاح.');
    }

    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:school_classes,name,' . $class->id,
            'description' => 'nullable|string|max:500',
        ]);

        $class->update($data);

        AuditLog::log('تعديل فصل', 'school_classes', $class->id, "تم تعديل الفصل: {$class->name}");

        return redirect()->route('admin.classes.index')
            ->with('success', 'تم تعديل الفصل بنجاح.');
    }

    public function destroy(SchoolClass $class)
    {
        $name = $class->name;
        $class->delete();

        AuditLog::log('حذف فصل', 'school_classes', $class->id, "تم حذف الفصل: {$name}");

        return redirect()->route('admin.classes.index')
            ->with('success', 'تم حذف الفصل بنجاح.');
    }
}

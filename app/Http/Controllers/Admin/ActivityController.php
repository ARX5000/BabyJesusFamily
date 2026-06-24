<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::withCount('students')->latest()->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:activities,name',
            'description' => 'nullable|string|max:500',
        ]);

        $activity = Activity::create($data);

        AuditLog::log('إنشاء نشاط', 'activities', $activity->id, "تم إنشاء النشاط: {$activity->name}");

        return redirect()->route('admin.activities.index')
            ->with('success', 'تم إنشاء النشاط بنجاح.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:2|max:100|unique:activities,name,' . $activity->id,
            'description' => 'nullable|string|max:500',
        ]);

        $activity->update($data);

        AuditLog::log('تعديل نشاط', 'activities', $activity->id, "تم تعديل النشاط: {$activity->name}");

        return redirect()->route('admin.activities.index')
            ->with('success', 'تم تعديل النشاط بنجاح.');
    }

    public function destroy(Activity $activity)
    {
        $name = $activity->name;
        $activity->delete();

        AuditLog::log('حذف نشاط', 'activities', $activity->id, "تم حذف النشاط: {$name}");

        return redirect()->route('admin.activities.index')
            ->with('success', 'تم حذف النشاط بنجاح.');
    }
}

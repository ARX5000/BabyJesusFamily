<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $classes    = SchoolClass::orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();

        return view('admin.reports.index', compact('classes', 'activities'));
    }

    public function export(Request $request)
    {
        $data = $request->validate([
            'filter'      => 'required|in:all,approved,pending,rejected,by_class,by_activity',
            'class_id'    => 'nullable|exists:school_classes,id',
            'activity_id' => 'nullable|exists:activities,id',
        ]);

        $filename = 'students_' . now()->format('Y_m_d_His') . '.xlsx';

        return Excel::download(
            new StudentsExport($data['filter'], $data['class_id'] ?? null, $data['activity_id'] ?? null),
            $filename
        );
    }
}

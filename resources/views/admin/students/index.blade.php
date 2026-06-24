@extends('layouts.app')

@section('title', 'الطلاب')
@section('page-title', 'إدارة الطلاب')

@section('content')

<!-- Search & Filter -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mb-6">
    <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="xl:col-span-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="ابحث بالاسم أو الرقم القومي أو الهاتف...">
        </div>
        <div>
            <select name="class_id" class="form-input">
                <option value="">جميع الفصول</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="status" class="form-input">
                <option value="">جميع الحالات</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>قيد الانتظار</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>مقبول</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوض</option>
            </select>
        </div>
        <div>
            <select name="activity_id" class="form-input">
                <option value="">جميع الأنشطة</option>
                @foreach($activities as $activity)
                    <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>{{ $activity->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2 xl:col-span-5">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                بحث
            </button>
            <a href="{{ route('admin.students.index') }}" class="btn-secondary">إعادة تعيين</a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <p class="text-sm text-slate-500">إجمالي النتائج: <strong class="text-slate-800">{{ $students->total() }}</strong></p>
        <a href="{{ route('admin.students.pending') }}" class="text-sm text-amber-600 hover:underline font-medium">طلبات الموافقة المعلقة</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الاسم</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الرقم القومي</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الهاتف</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الفصل</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الأنشطة</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الحالة</th>
                    <th class="px-5 py-3 text-right text-slate-600 font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.students.show', $student) }}" class="font-semibold text-slate-800 hover:text-primary-600">
                                {{ $student->full_name }}
                            </a>
                        </td>
                        <td class="px-5 py-3 text-slate-500 font-mono">{{ $student->national_id }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $student->phone }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $student->schoolClass?->name }}</td>
                        <td class="px-5 py-3">
                            <span class="bg-pink-100 text-pink-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                                {{ $student->activities->count() }} نشاط
                            </span>
                        </td>
                        <td class="px-5 py-3"><span class="badge-{{ $student->status }}">{{ $student->status_label }}</span></td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.students.show', $student) }}" class="text-slate-500 hover:text-slate-800 text-xs">عرض</a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="text-primary-600 hover:text-primary-800 text-xs">تعديل</a>
                                @if($student->isPending())
                                    <form method="POST" action="{{ route('admin.students.approve', $student) }}">
                                        @csrf<button class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">قبول</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.students.reject', $student) }}">
                                        @csrf<button class="text-xs text-amber-600 hover:text-amber-800 font-medium">رفض</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('حذف الطالب؟')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-500 hover:text-red-700 font-medium">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-12 text-center text-slate-400">لا توجد نتائج مطابقة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $students->links() }}</div>
    @endif
</div>
@endsection

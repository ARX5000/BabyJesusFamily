@extends('layouts.app')
@section('title', 'طلابي')
@section('page-title', 'طلاب فصولي')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">طلاب فصولي</h2>
        <p class="text-slate-500 text-sm mt-1">عرض وبحث الطلاب في الفصول المُسندة إليك</p>
    </div>
    <a href="{{ route('teacher.students.create') }}" class="btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        إضافة طالب
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-input flex-1 min-w-48" placeholder="ابحث بالاسم أو الرقم القومي أو الهاتف...">
        <select name="class_id" class="form-input w-48">
            <option value="">جميع فصولي</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">بحث</button>
        <a href="{{ route('teacher.students.index') }}" class="btn-secondary">إعادة تعيين</a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <p class="text-sm text-slate-500">النتائج: <strong class="text-slate-800">{{ $students->total() }}</strong></p>
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
                            <a href="{{ route('teacher.students.show', $student) }}" class="font-semibold text-slate-800 hover:text-primary-600">{{ $student->full_name }}</a>
                        </td>
                        <td class="px-5 py-3 font-mono text-slate-500">{{ $student->national_id }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $student->phone }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $student->schoolClass?->name }}</td>
                        <td class="px-5 py-3">
                            <span class="bg-pink-100 text-pink-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $student->activities->count() }} نشاط</span>
                        </td>
                        <td class="px-5 py-3"><span class="badge-{{ $student->status }}">{{ $student->status_label }}</span></td>
                        <td class="px-5 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('teacher.students.show', $student) }}" class="text-slate-500 hover:text-slate-800 text-xs">عرض</a>
                                <a href="{{ route('teacher.students.edit', $student) }}" class="text-primary-600 hover:text-primary-800 text-xs">تعديل</a>
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

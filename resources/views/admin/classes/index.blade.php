@extends('layouts.app')

@section('title', 'الفصول')
@section('page-title', 'إدارة الفصول')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">الفصول الدراسية</h2>
        <p class="text-slate-500 text-sm mt-1">إدارة فصول الكنيسة</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        إضافة فصل
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">#</th>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">اسم الفصل</th>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">الوصف</th>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">الطلاب</th>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">المعلمون</th>
                <th class="px-6 py-4 text-right font-semibold text-slate-600">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($classes as $class)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $class->name }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $class->description ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-semibold">{{ $class->students_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-violet-100 text-violet-700 px-2.5 py-1 rounded-full text-xs font-semibold">{{ $class->teachers_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.classes.edit', $class) }}" class="text-primary-600 hover:text-primary-800 font-medium text-xs">تعديل</a>
                            <span class="text-slate-200">|</span>
                            <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفصل؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">لا توجد فصول بعد. <a href="{{ route('admin.classes.create') }}" class="text-primary-600 hover:underline">أضف فصلاً الآن</a></td></tr>
            @endforelse
        </tbody>
    </table>

    @if($classes->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $classes->links() }}
        </div>
    @endif
</div>
@endsection

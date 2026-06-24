@extends('layouts.app')

@section('title', 'الأنشطة')
@section('page-title', 'إدارة الأنشطة')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">الأنشطة</h2>
        <p class="text-slate-500 text-sm mt-1">إدارة أنشطة الكنيسة</p>
    </div>
    <a href="{{ route('admin.activities.create') }}" class="btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        إضافة نشاط
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($activities as $activity)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">{{ $activity->name }}</h3>
                    @if($activity->description)
                        <p class="text-slate-500 text-sm mt-1">{{ $activity->description }}</p>
                    @endif
                    <div class="mt-3">
                        <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $activity->students_count }} طالب
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 mr-4">
                    <a href="{{ route('admin.activities.edit', $activity) }}" class="text-xs text-primary-600 hover:text-primary-800 font-medium">تعديل</a>
                    <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}" onsubmit="return confirm('حذف النشاط: {{ $activity->name }}؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 bg-white rounded-2xl border border-slate-100 p-12 text-center">
            <p class="text-slate-400 mb-4">لا توجد أنشطة بعد</p>
            <a href="{{ route('admin.activities.create') }}" class="btn-primary inline-flex">إضافة نشاط</a>
        </div>
    @endforelse
</div>

@if($activities->hasPages())
    <div class="mt-6">{{ $activities->links() }}</div>
@endif
@endsection

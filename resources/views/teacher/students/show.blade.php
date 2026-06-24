@extends('layouts.app')
@section('title', 'ملف الطالب')
@section('page-title', 'ملف الطالب')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <span class="text-primary-700 text-xl font-bold">{{ mb_substr($student->full_name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $student->full_name }}</h2>
                    <p class="text-slate-500 text-sm">{{ $student->schoolClass?->name }}</p>
                    <span class="badge-{{ $student->status }} mt-2 inline-block">{{ $student->status_label }}</span>
                </div>
            </div>
            <a href="{{ route('teacher.students.edit', $student) }}" class="btn-primary">تعديل</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <h3 class="font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">المعلومات الشخصية</h3>
            <dl class="space-y-2.5 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">الرقم القومي</dt><dd class="font-mono font-semibold">{{ $student->national_id }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">الهاتف</dt><dd class="font-semibold">{{ $student->phone }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">الجنس</dt><dd class="font-semibold">{{ $student->gender_label }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">تاريخ الميلاد</dt><dd class="font-semibold">{{ $student->birth_date?->format('Y-m-d') ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">العنوان</dt><dd class="font-semibold text-left">{{ $student->address ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">تاريخ التسجيل</dt><dd class="font-semibold">{{ $student->created_at->format('Y-m-d') }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <h3 class="font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">معلومات ولي الأمر</h3>
            <dl class="space-y-2.5 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">اسم الوالد</dt><dd class="font-semibold">{{ $student->parent_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">هاتف الوالد</dt><dd class="font-semibold">{{ $student->parent_phone }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 md:col-span-2">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-2">
                <h3 class="font-bold text-slate-700">الأنشطة</h3>
                <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-bold">الأنشطة المشارك بها: {{ $student->activities->count() }}</span>
            </div>
            @if($student->activities->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach($student->activities as $activity)
                        <span class="bg-primary-100 text-primary-700 px-3 py-1.5 rounded-xl text-sm font-medium">{{ $activity->name }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-slate-400 text-sm">لم يُسجَّل في أي نشاط بعد</p>
            @endif
        </div>
    </div>

    <div class="mt-5">
        <a href="{{ route('teacher.students.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            العودة للقائمة
        </a>
    </div>
</div>
@endsection

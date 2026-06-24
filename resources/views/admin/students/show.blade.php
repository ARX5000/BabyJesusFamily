@extends('layouts.app')

@section('title', 'ملف الطالب')
@section('page-title', 'ملف الطالب')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <span class="text-primary-700 text-2xl font-bold">{{ mb_substr($student->full_name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ $student->full_name }}</h2>
                    <p class="text-slate-500 text-sm mt-1">{{ $student->schoolClass?->name }}</p>
                    <div class="mt-2">
                        <span class="badge-{{ $student->status }} text-sm px-3 py-1">{{ $student->status_label }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.students.edit', $student) }}" class="btn-primary">تعديل</a>
                @if($student->isPending())
                    <form method="POST" action="{{ route('admin.students.approve', $student) }}" class="inline">
                        @csrf<button class="btn-success">قبول</button>
                    </form>
                    <form method="POST" action="{{ route('admin.students.reject', $student) }}" class="inline">
                        @csrf<button class="btn-danger">رفض</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Personal Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">المعلومات الشخصية</h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">الرقم القومي</dt>
                    <dd class="text-sm font-mono font-semibold text-slate-800">{{ $student->national_id }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">رقم الهاتف</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->phone }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">الجنس</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->gender_label }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">تاريخ الميلاد</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->birth_date?->format('Y-m-d') ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">العنوان</dt>
                    <dd class="text-sm font-semibold text-slate-800 text-left">{{ $student->address ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">تاريخ التسجيل</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->created_at->format('Y-m-d') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">سُجِّل بواسطة</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->creator?->name ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Parent Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">معلومات ولي الأمر</h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">اسم الوالد</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->parent_name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-slate-500">هاتف الوالد</dt>
                    <dd class="text-sm font-semibold text-slate-800">{{ $student->parent_phone }}</dd>
                </div>
            </dl>
        </div>

        <!-- Activities -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="font-bold text-slate-700">الأنشطة</h3>
                <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-bold">
                    الأنشطة المشارك بها: {{ $student->activities->count() }}
                </span>
            </div>
            @if($student->activities->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach($student->activities as $activity)
                        <span class="bg-primary-100 text-primary-700 px-3 py-1.5 rounded-xl text-sm font-medium">
                            {{ $activity->name }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-slate-400 text-sm">لم يُسجَّل في أي نشاط بعد</p>
            @endif
        </div>

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.students.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            العودة للقائمة
        </a>
    </div>
</div>
@endsection

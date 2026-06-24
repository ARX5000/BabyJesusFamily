@extends('layouts.app')
@section('title', 'لوحة تحكم المعلم')
@section('page-title', 'لوحة تحكم المعلم')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="stat-card">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['total_students'] }}</p>
        <p class="text-sm text-slate-500 mt-1">إجمالي الطلاب في فصولي</p>
    </div>
    <div class="stat-card">
        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['pending_students'] }}</p>
        <p class="text-sm text-slate-500 mt-1">في انتظار الموافقة</p>
    </div>
    <div class="stat-card">
        <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $stats['classes_count'] }}</p>
        <p class="text-sm text-slate-500 mt-1">فصول مُسندة إليّ</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <a href="{{ route('teacher.students.create') }}"
       class="group bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-6 text-white hover:shadow-lg hover:shadow-primary-200 transition-all duration-300">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <h3 class="text-xl font-bold">إضافة طالب جديد</h3>
        <p class="text-white/70 text-sm mt-1">تسجيل طالب في أحد فصولك</p>
    </a>

    <a href="{{ route('teacher.students.index') }}"
       class="group bg-white rounded-2xl p-6 border border-slate-100 hover:shadow-md transition-all duration-300">
        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-100 transition-colors">
            <svg class="w-6 h-6 text-slate-600 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800">البحث عن طالب</h3>
        <p class="text-slate-500 text-sm mt-1">عرض وبحث طلاب فصولك</p>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Assigned Classes -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">فصولي المُسندة</h3>
        </div>
        <div class="p-4 space-y-3">
            @forelse($assignedClasses as $class)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <span class="text-cyan-700 text-xs font-bold">{{ mb_substr($class->name, 0, 2) }}</span>
                        </div>
                        <span class="font-semibold text-slate-800">{{ $class->name }}</span>
                    </div>
                    <span class="text-sm text-slate-500">{{ $class->students_count }} طالب</span>
                </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-4">لم يتم إسناد أي فصل إليك بعد</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700">آخر تسجيلاتي</h3>
            <a href="{{ route('teacher.students.index') }}" class="text-primary-600 text-sm hover:underline">عرض الكل</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recentStudents as $student)
                <div class="px-5 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div>
                        <a href="{{ route('teacher.students.show', $student) }}" class="font-medium text-slate-800 hover:text-primary-600">{{ $student->full_name }}</a>
                        <p class="text-xs text-slate-400">{{ $student->schoolClass?->name }}</p>
                    </div>
                    <span class="badge-{{ $student->status }} text-xs">{{ $student->status_label }}</span>
                </div>
            @empty
                <p class="text-center text-slate-400 py-8 text-sm">لم تقم بتسجيل أي طالب بعد</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

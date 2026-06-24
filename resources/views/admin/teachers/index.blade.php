@extends('layouts.app')

@section('title', 'المعلمون')
@section('page-title', 'إدارة المعلمين')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">المعلمون</h2>
        <p class="text-slate-500 text-sm mt-1">إدارة حسابات المعلمين</p>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        إضافة معلم
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-input flex-1" placeholder="ابحث بالاسم أو البريد الإلكتروني...">
        <button type="submit" class="btn-primary">بحث</button>
        <a href="{{ route('admin.teachers.index') }}" class="btn-secondary">إعادة تعيين</a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">المعلم</th>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">البريد الإلكتروني</th>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">الهاتف</th>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">الفصول</th>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">الحالة</th>
                <th class="px-5 py-4 text-right text-slate-600 font-semibold">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($teachers as $teacher)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-violet-100 rounded-full flex items-center justify-center">
                                <span class="text-violet-700 font-bold text-sm">{{ mb_substr($teacher->name, 0, 1) }}</span>
                            </div>
                            <span class="font-semibold text-slate-800">{{ $teacher->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-slate-500">{{ $teacher->email }}</td>
                    <td class="px-5 py-4 text-slate-500">{{ $teacher->phone ?? '-' }}</td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($teacher->classes as $class)
                                <span class="bg-cyan-100 text-cyan-700 px-2 py-0.5 rounded-full text-xs font-medium">{{ $class->name }}</span>
                            @empty
                                <span class="text-slate-400 text-xs">لا يوجد</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge-{{ $teacher->status }}">{{ $teacher->status === 'active' ? 'نشط' : 'معطل' }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-primary-600 hover:text-primary-800 text-xs font-medium">تعديل</a>
                            <form method="POST" action="{{ route('admin.teachers.toggle-status', $teacher) }}">
                                @csrf
                                <button class="text-xs font-medium {{ $teacher->status === 'active' ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800' }}">
                                    {{ $teacher->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400">لا يوجد معلمون بعد</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($teachers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $teachers->links() }}</div>
    @endif
</div>
@endsection

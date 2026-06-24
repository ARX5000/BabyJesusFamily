@extends('layouts.app')

@section('title', 'طلبات الموافقة المعلقة')
@section('page-title', 'طلبات الموافقة')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">طلبات الموافقة المعلقة</h2>
            <p class="text-slate-500 text-sm">{{ $students->total() }} طلب في انتظار المراجعة</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-amber-50 border-b border-amber-100">
                <tr>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الاسم</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الرقم القومي</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الهاتف</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الفصل</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">أضافه</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">تاريخ الطلب</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الإجراء</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.students.show', $student) }}" class="font-semibold text-slate-800 hover:text-primary-600">
                                {{ $student->full_name }}
                            </a>
                        </td>
                        <td class="px-5 py-4 font-mono text-slate-500">{{ $student->national_id }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $student->phone }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $student->schoolClass?->name }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $student->creator?->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $student->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-4">
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.students.approve', $student) }}">
                                    @csrf
                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                        ✓ قبول
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.students.reject', $student) }}">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                        ✕ رفض
                                    </button>
                                </form>
                                <a href="{{ route('admin.students.show', $student) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                    عرض
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="text-emerald-500 text-5xl mb-3">✓</div>
                            <p class="text-slate-500 font-medium">لا توجد طلبات معلقة! تم مراجعة جميع الطلبات.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $students->links() }}</div>
    @endif
</div>
@endsection

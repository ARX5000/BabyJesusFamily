@extends('layouts.app')
@section('title', 'سجل العمليات')
@section('page-title', 'سجل العمليات')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">سجل العمليات</h2>
    <p class="text-slate-500 text-sm mt-1">تتبع جميع الإجراءات التي تمت في النظام</p>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-input flex-1" placeholder="ابحث في العمليات...">
        <button type="submit" class="btn-primary">بحث</button>
        <a href="{{ route('admin.audit-logs.index') }}" class="btn-secondary">إعادة تعيين</a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">المستخدم</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">العملية</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">التفاصيل</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">الجدول</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">عنوان IP</th>
                    <th class="px-5 py-4 text-right text-slate-600 font-semibold">التاريخ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-primary-100 rounded-full flex items-center justify-center">
                                    <span class="text-primary-700 text-xs font-bold">{{ mb_substr($log->user?->name ?? 'N', 0, 1) }}</span>
                                </div>
                                <span class="text-slate-700 font-medium">{{ $log->user?->name ?? 'نظام' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="bg-primary-100 text-primary-800 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $log->action }}</span>
                        </td>
                        <td class="px-5 py-3 text-slate-500 max-w-xs truncate">{{ $log->description ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-500 font-mono text-xs">{{ $log->table_name ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-400 text-xs whitespace-nowrap">
                            <span title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400">لا توجد سجلات بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $logs->links() }}</div>
    @endif
</div>
@endsection

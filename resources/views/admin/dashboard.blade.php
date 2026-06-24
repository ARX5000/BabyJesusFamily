@extends('layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-4 mb-8">
    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['total_students'] }}</p>
        <p class="text-xs text-slate-500 mt-1">إجمالي الطلاب</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['approved_students'] }}</p>
        <p class="text-xs text-slate-500 mt-1">مقبولون</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['pending_students'] }}</p>
        <p class="text-xs text-slate-500 mt-1">قيد الانتظار</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['rejected_students'] }}</p>
        <p class="text-xs text-slate-500 mt-1">مرفوضون</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['total_teachers'] }}</p>
        <p class="text-xs text-slate-500 mt-1">المعلمون</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['total_classes'] }}</p>
        <p class="text-xs text-slate-500 mt-1">الفصول</p>
    </div>

    <div class="stat-card col-span-1">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['total_activities'] }}</p>
        <p class="text-xs text-slate-500 mt-1">الأنشطة</p>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-bold text-slate-700 mb-4">الطلاب حسب الفصل</h3>
        <canvas id="classChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-bold text-slate-700 mb-4">الطلاب حسب النشاط</h3>
        <canvas id="activityChart" height="200"></canvas>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700">آخر التسجيلات</h3>
            <a href="{{ route('admin.students.index') }}" class="text-primary-600 text-sm hover:underline">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">الاسم</th>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">الفصل</th>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentStudents as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.students.show', $student) }}" class="font-medium text-slate-800 hover:text-primary-600">
                                    {{ $student->full_name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $student->schoolClass?->name }}</td>
                            <td class="px-4 py-3">
                                <span class="badge-{{ $student->status }}">{{ $student->status_label }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-slate-400">لا يوجد طلاب بعد</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pending Approvals -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700">طلبات موافقة معلقة</h3>
            <a href="{{ route('admin.students.pending') }}" class="text-amber-600 text-sm hover:underline">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">الاسم</th>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">الفصل</th>
                        <th class="px-4 py-3 text-right text-slate-600 font-semibold">إجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendingStudents as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $student->full_name }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $student->schoolClass?->name }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.students.approve', $student) }}">
                                        @csrf
                                        <button type="submit" class="text-xs bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-2 py-1 rounded-lg font-semibold transition-colors">قبول</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.students.reject', $student) }}">
                                        @csrf
                                        <button type="submit" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-2 py-1 rounded-lg font-semibold transition-colors">رفض</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-slate-400">لا توجد طلبات معلقة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const classData    = @json($studentsPerClass);
const activityData = @json($studentsPerActivity);

const colors = ['#5a78ff','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899','#14b8a6'];

// Class chart
new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: classData.map(d => d.name),
        datasets: [{
            label: 'عدد الطلاب',
            data: classData.map(d => d.count),
            backgroundColor: colors,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Activity chart
new Chart(document.getElementById('activityChart'), {
    type: 'doughnut',
    data: {
        labels: activityData.map(d => d.name),
        datasets: [{
            data: activityData.map(d => d.count),
            backgroundColor: colors,
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 15, font: { family: 'Cairo' } } }
        }
    }
});
</script>
@endpush

@extends('layouts.app')
@section('title', 'تصدير Excel')
@section('page-title', 'تصدير تقارير Excel')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">تصدير بيانات الطلاب</h2>
                <p class="text-slate-500 text-sm">اختر نوع التقرير وقم بتنزيله بصيغة Excel</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.reports.export') }}" class="space-y-6">
            @csrf

            <!-- Filter Type -->
            <div>
                <label class="form-label">نوع التقرير <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 gap-3">
                    @php
                        $filters = [
                            'all'         => ['label' => 'جميع الطلاب', 'icon' => '👥', 'desc' => 'تصدير بيانات جميع الطلاب'],
                            'approved'    => ['label' => 'المقبولون فقط', 'icon' => '✅', 'desc' => 'الطلاب المعتمدون فقط'],
                            'pending'     => ['label' => 'قيد الانتظار', 'icon' => '⏳', 'desc' => 'الطلاب الذين لم يُراجَعوا بعد'],
                            'rejected'    => ['label' => 'المرفوضون', 'icon' => '❌', 'desc' => 'الطلاب المرفوضون'],
                            'by_class'    => ['label' => 'حسب الفصل', 'icon' => '🏫', 'desc' => 'طلاب فصل محدد'],
                            'by_activity' => ['label' => 'حسب النشاط', 'icon' => '🎭', 'desc' => 'طلاب نشاط محدد'],
                        ];
                    @endphp
                    @foreach($filters as $value => $info)
                        <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-100 hover:border-primary-300 cursor-pointer transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                            <input type="radio" name="filter" value="{{ $value }}" class="accent-primary-600" {{ old('filter', 'all') === $value ? 'checked' : '' }}>
                            <span class="text-2xl">{{ $info['icon'] }}</span>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $info['label'] }}</p>
                                <p class="text-xs text-slate-500">{{ $info['desc'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('filter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Class selector (shown when by_class) -->
            <div id="classSelectorWrap" class="hidden">
                <label class="form-label">اختر الفصل</label>
                <select name="class_id" class="form-input">
                    <option value="">-- اختر فصل --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Activity selector (shown when by_activity) -->
            <div id="activitySelectorWrap" class="hidden">
                <label class="form-label">اختر النشاط</label>
                <select name="activity_id" class="form-input">
                    <option value="">-- اختر نشاط --</option>
                    @foreach($activities as $activity)
                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                    @endforeach
                </select>
                @error('activity_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-success w-full justify-center py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                تنزيل ملف Excel
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const radios = document.querySelectorAll('input[name="filter"]');
    const classWrap    = document.getElementById('classSelectorWrap');
    const activityWrap = document.getElementById('activitySelectorWrap');

    function updateSelectors() {
        const val = document.querySelector('input[name="filter"]:checked')?.value;
        classWrap.classList.toggle('hidden',    val !== 'by_class');
        activityWrap.classList.toggle('hidden', val !== 'by_activity');
    }

    radios.forEach(r => r.addEventListener('change', updateSelectors));
    updateSelectors();
</script>
@endpush

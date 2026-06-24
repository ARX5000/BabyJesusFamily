@extends('layouts.app')
@section('title', 'إضافة طالب')
@section('page-title', 'تسجيل طالب جديد')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-11 h-11 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">تسجيل طالب جديد</h2>
                <p class="text-slate-500 text-sm">سيتم إرسال الطلب للمسؤول للموافقة عليه</p>
            </div>
        </div>

        <form method="POST" action="{{ route('teacher.students.store') }}" class="space-y-6">
            @csrf

            <!-- Section: Personal Info -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">المعلومات الشخصية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-input" placeholder="الاسم بالكامل">
                        @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الرقم القومي <span class="text-red-500">*</span></label>
                        <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-input font-mono" placeholder="14 رقم" maxlength="14">
                        @error('national_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">رقم الهاتف <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="01XXXXXXXXX">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الجنس <span class="text-red-500">*</span></label>
                        <select name="gender" class="form-input">
                            <option value="">-- اختر --</option>
                            <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-input">
                        @error('birth_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الفصل <span class="text-red-500">*</span></label>
                        <select name="class_id" class="form-input">
                            <option value="">-- اختر الفصل --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-input" placeholder="العنوان الكامل">
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Section: Parent Info -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">معلومات ولي الأمر</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">اسم الوالد <span class="text-red-500">*</span></label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}" class="form-input">
                        @error('parent_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">هاتف الوالد <span class="text-red-500">*</span></label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone') }}" class="form-input" placeholder="01XXXXXXXXX">
                        @error('parent_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Section: Activities -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">الأنشطة (اختياري)</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    @foreach($activities as $activity)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="activities[]"
                                value="{{ $activity->id }}"
                                class="w-4 h-4 rounded accent-primary-600"
                                {{ in_array($activity->id, old('activities', [])) ? 'checked' : '' }}
                            >
                            <span class="text-sm text-slate-700">{{ $activity->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    تسجيل الطالب
                </button>
                <a href="{{ route('teacher.students.index') }}" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection

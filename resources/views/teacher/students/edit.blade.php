@extends('layouts.app')
@section('title', 'تعديل بيانات الطالب')
@section('page-title', 'تعديل بيانات الطالب')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">تعديل: {{ $student->full_name }}</h2>

        <form method="POST" action="{{ route('teacher.students.update', $student) }}" class="space-y-6">
            @csrf @method('PUT')

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">المعلومات الشخصية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" class="form-input">
                        @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الرقم القومي <span class="text-red-500">*</span></label>
                        <input type="text" name="national_id" value="{{ old('national_id', $student->national_id) }}" class="form-input font-mono" maxlength="14">
                        @error('national_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">رقم الهاتف <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="form-input">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الجنس <span class="text-red-500">*</span></label>
                        <select name="gender" class="form-input">
                            <option value="male"   {{ old('gender', $student->gender) === 'male'   ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date?->format('Y-m-d')) }}" class="form-input">
                        @error('birth_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">الفصل <span class="text-red-500">*</span></label>
                        <select name="class_id" class="form-input">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" value="{{ old('address', $student->address) }}" class="form-input">
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">معلومات ولي الأمر</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">اسم الوالد <span class="text-red-500">*</span></label>
                        <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" class="form-input">
                        @error('parent_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">هاتف الوالد <span class="text-red-500">*</span></label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}" class="form-input">
                        @error('parent_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">الأنشطة</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    @foreach($activities as $activity)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="activities[]"
                                value="{{ $activity->id }}"
                                class="w-4 h-4 rounded accent-primary-600"
                                {{ in_array($activity->id, old('activities', $student->activities->pluck('id')->toArray())) ? 'checked' : '' }}
                            >
                            <span class="text-sm text-slate-700">{{ $activity->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
                <a href="{{ route('teacher.students.show', $student) }}" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection

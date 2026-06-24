@extends('layouts.app')
@section('title', 'تعديل بيانات المعلم')
@section('page-title', 'تعديل المعلم')
@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">تعديل: {{ $teacher->name }}</h2>

        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">الاسم الكامل <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" class="form-input">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">البريد الإلكتروني <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" class="form-input">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="form-input">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">الحالة <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input">
                        <option value="active"   {{ old('status', $teacher->status) === 'active'   ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ old('status', $teacher->status) === 'inactive' ? 'selected' : '' }}>معطل</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Classes Assignment -->
            <div>
                <label class="form-label">الفصول المُسنَدة</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    @foreach($classes as $class)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                name="classes[]"
                                value="{{ $class->id }}"
                                class="w-4 h-4 rounded accent-primary-600"
                                {{ in_array($class->id, old('classes', $teacher->classes->pluck('id')->toArray())) ? 'checked' : '' }}
                            >
                            <span class="text-sm text-slate-700">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>

    <!-- Reset Password -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-5">إعادة تعيين كلمة المرور</h3>

        <form method="POST" action="{{ route('admin.teachers.reset-password', $teacher) }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">كلمة المرور الجديدة <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="form-input" placeholder="8 أحرف على الأقل">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>
            <button type="submit" class="btn-danger">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                تغيير كلمة المرور
            </button>
        </form>
    </div>

</div>
@endsection

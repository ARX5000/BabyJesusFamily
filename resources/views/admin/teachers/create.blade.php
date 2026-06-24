@extends('layouts.app')
@section('title', 'إضافة معلم')
@section('page-title', 'إضافة معلم جديد')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">إضافة معلم جديد</h2>

        <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">الاسم الكامل <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">البريد الإلكتروني <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="01XXXXXXXXX">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">كلمة المرور <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="form-input" placeholder="8 أحرف على الأقل">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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
                                {{ in_array($class->id, old('classes', [])) ? 'checked' : '' }}
                            >
                            <span class="text-sm text-slate-700">{{ $class->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('classes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">إنشاء الحساب</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection

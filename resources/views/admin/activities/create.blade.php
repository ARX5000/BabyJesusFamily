@extends('layouts.app')
@section('title', 'إضافة نشاط')
@section('page-title', 'إضافة نشاط')
@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">إضافة نشاط جديد</h2>
        <form method="POST" action="{{ route('admin.activities.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="form-label">اسم النشاط <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="مثال: الكورال، المسرح">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">الوصف</label>
                <textarea name="description" rows="3" class="form-input" placeholder="وصف النشاط">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">حفظ النشاط</button>
                <a href="{{ route('admin.activities.index') }}" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection

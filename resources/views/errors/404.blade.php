@extends('layouts.auth')
@section('title', 'الصفحة غير موجودة')
@section('content')
<div class="text-center py-8">
    <div class="text-7xl mb-4">🔍</div>
    <h2 class="text-2xl font-bold text-white mb-2">الصفحة غير موجودة</h2>
    <p class="text-slate-300 mb-6">الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>
    <a href="{{ url('/') }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl font-medium transition-all">
        العودة للرئيسية
    </a>
</div>
@endsection

@extends('layouts.auth')
@section('title', 'غير مصرح')
@section('content')
<div class="text-center py-8">
    <div class="text-7xl mb-4">🚫</div>
    <h2 class="text-2xl font-bold text-white mb-2">غير مصرح بالوصول</h2>
    <p class="text-slate-300 mb-6">ليس لديك صلاحية لعرض هذه الصفحة.</p>
    <a href="{{ url()->previous() }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl font-medium transition-all">
        العودة للخلف
    </a>
</div>
@endsection

@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')
    <h2 class="text-2xl font-bold text-white text-center mb-6">تسجيل الدخول</h2>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-4 bg-red-500/20 border border-red-400/30 rounded-xl px-4 py-3">
            @foreach($errors->all() as $error)
                <p class="text-red-200 text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-200 mb-2">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                placeholder="admin@example.com"
                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
            >
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-200 mb-2">كلمة المرور</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
            >
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded accent-primary-600">
            <label for="remember" class="text-sm text-slate-300">تذكرني</label>
        </div>

        <!-- Submit -->
        <button
            type="submit"
            id="login-btn"
            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-primary-600/40 mt-2"
        >
            دخول إلى النظام
        </button>
    </form>
@endsection

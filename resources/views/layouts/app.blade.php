<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Baby Jesus Family') | عائلة يسوع الطفل</title>
    <meta name="description" content="نظام إدارة فصول الكنيسة - عائلة يسوع الطفل">

    <!-- Google Fonts - Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'cairo': ['Cairo', 'sans-serif'] },
                    colors: {
                        primary: {
                            50:'#f0f4ff', 100:'#e0e9ff', 200:'#c7d7ff',
                            300:'#a5beff', 400:'#7c9cff', 500:'#5a78ff',
                            600:'#3d58f5', 700:'#3045e0', 800:'#2a3ab5', 900:'#27358f',
                        },
                        church: { gold:'#c9a227', cross:'#7b2d8b' }
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Cairo', sans-serif; }

        /* Global utility classes */
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem; border-radius: 0.75rem;
            color: #cbd5e1; transition: all 0.2s;
            text-decoration: none; font-size: 0.9rem;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-link.active { background: rgba(255,255,255,0.2); color: #fff; font-weight: 600; }
        .sidebar-link svg { flex-shrink: 0; }

        .stat-card { @apply bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300; }
        .btn-primary { @apply bg-primary-600 hover:bg-primary-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2; }
        .btn-secondary { @apply bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2; }
        .btn-danger { @apply bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2; }
        .btn-success { @apply bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2; }
        .form-input { @apply w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none transition-all duration-200; }
        .form-label { @apply block text-sm font-semibold text-slate-700 mb-2; }
        .badge-pending  { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800; }
        .badge-approved { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800; }
        .badge-rejected { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800; }
        .badge-active   { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800; }
        .badge-inactive { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        /* Sidebar */
        #sidebar {
            width: 260px;
            flex-shrink: 0;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: -4px 0 24px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
            z-index: 50;
        }

        /* Mobile: sidebar hidden off-screen to the left (RTL = left side is "outside") */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 0; bottom: 0; right: 0;
                transform: translateX(100%);
            }
            #sidebar.open { transform: translateX(0); }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 overflow-hidden h-screen">

{{-- RTL: sidebar on RIGHT, content on LEFT --}}
<div style="display:flex; flex-direction:row; height:100vh; overflow:hidden;">

    {{-- Main Content (LEFT in RTL) --}}
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; min-width:0;">

        <!-- Top Header -->
        <header class="bg-white border-b border-slate-100 px-5 py-3.5 flex items-center justify-between shadow-sm flex-shrink-0">
            <div class="flex items-center gap-3">
                <!-- Mobile toggle -->
                <button onclick="toggleSidebar()" id="menuToggle"
                        class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'لوحة التحكم')</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-400 hidden md:block">
                    {{ now()->locale('ar')->translatedFormat('l، j F Y') }}
                </span>
                <!-- User badge -->
                <div class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-full">
                    <div class="w-6 h-6 bg-primary-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-700 hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-5 pt-3">
            @if(session('success'))
                <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-0">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-0">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main style="flex:1; overflow-y:auto; padding:1.25rem 1.5rem;">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- SIDEBAR (RIGHT in RTL) --}}
    <aside id="sidebar">

        <!-- Brand -->
        <div style="padding:1.25rem 1rem; border-bottom:1px solid rgba(255,255,255,0.08);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:2.5rem; height:2.5rem; background:#7b2d8b; border-radius:0.75rem; display:flex; align-items:center; justify-content:center; color:white; font-size:1.1rem; flex-shrink:0;">✝</div>
                <div>
                    <p style="color:white; font-weight:700; font-size:0.875rem; line-height:1.25;">عائلة يسوع الطفل</p>
                    <p style="color:#94a3b8; font-size:0.7rem;">Baby Jesus Family</p>
                </div>
            </div>
        </div>

        <!-- User -->
        <div style="padding:0.875rem 1rem; border-bottom:1px solid rgba(255,255,255,0.08);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:2.25rem; height:2.25rem; background:#3d58f5; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:0.875rem; flex-shrink:0;">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div style="min-width:0; flex:1;">
                    <p style="color:white; font-size:0.875rem; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->name }}</p>
                    <p style="color:#64748b; font-size:0.75rem;">{{ auth()->user()->hasRole('admin') ? 'مسؤول' : 'معلم' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav style="flex:1; overflow-y:auto; padding:0.75rem;">
            @if(auth()->user()->hasRole('admin'))
                <p style="color:#475569; font-size:0.7rem; font-weight:700; padding:0.5rem 0.75rem; text-transform:uppercase; letter-spacing:0.05em; margin-top:0.25rem;">الرئيسية</p>

                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    لوحة التحكم
                </a>

                <p style="color:#475569; font-size:0.7rem; font-weight:700; padding:0.5rem 0.75rem; text-transform:uppercase; letter-spacing:0.05em; margin-top:0.75rem;">الإدارة</p>

                <a href="{{ route('admin.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.students.index') || request()->routeIs('admin.students.show') || request()->routeIs('admin.students.edit') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    الطلاب
                </a>

                <a href="{{ route('admin.students.pending') }}" class="sidebar-link {{ request()->routeIs('admin.students.pending') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    طلبات الموافقة
                </a>

                <a href="{{ route('admin.classes.index') }}" class="sidebar-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    الفصول
                </a>

                <a href="{{ route('admin.activities.index') }}" class="sidebar-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    الأنشطة
                </a>

                <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    المعلمون
                </a>

                <p style="color:#475569; font-size:0.7rem; font-weight:700; padding:0.5rem 0.75rem; text-transform:uppercase; letter-spacing:0.05em; margin-top:0.75rem;">التقارير</p>

                <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    تصدير Excel
                </a>

                <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    سجل العمليات
                </a>
            @else
                <p style="color:#475569; font-size:0.7rem; font-weight:700; padding:0.5rem 0.75rem; text-transform:uppercase; letter-spacing:0.05em;">الرئيسية</p>

                <a href="{{ route('teacher.dashboard') }}" class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    لوحة التحكم
                </a>

                <a href="{{ route('teacher.students.index') }}" class="sidebar-link {{ request()->routeIs('teacher.students.index') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    طلابي
                </a>

                <a href="{{ route('teacher.students.create') }}" class="sidebar-link {{ request()->routeIs('teacher.students.create') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    إضافة طالب
                </a>
            @endif
        </nav>

        <!-- Logout -->
        <div style="padding:0.75rem; border-top:1px solid rgba(255,255,255,0.08);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-radius:0.75rem; color:#cbd5e1; background:none; border:none; cursor:pointer; font-family:Cairo,sans-serif; font-size:0.9rem; transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(239,68,68,0.15)'; this.style.color='#fca5a5';"
                        onmouseout="this.style.background='none'; this.style.color='#cbd5e1';">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

</div>{{-- end main flex --}}

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
}
</script>

@stack('scripts')
</body>
</html>

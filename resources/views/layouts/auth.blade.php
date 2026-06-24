<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'تسجيل الدخول') | عائلة يسوع الطفل</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
                            500: '#5a78ff', 600: '#3d58f5', 700: '#3045e0',
                        }
                    }
                }
            }
        }
    </script>
    <style>* { font-family: 'Cairo', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-slate-800 via-slate-900 to-purple-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur rounded-2xl mb-4 border border-white/20">
                <span class="text-4xl text-white">✝</span>
            </div>
            <h1 class="text-3xl font-bold text-white">عائلة يسوع الطفل</h1>
            <p class="text-slate-300 mt-1">Baby Jesus Family</p>
        </div>

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl">
            @yield('content')
        </div>

        <p class="text-center text-slate-400 text-sm mt-6">
            &copy; {{ date('Y') }} Baby Jesus Family — جميع الحقوق محفوظة
        </p>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Âm nhạc trực tuyến' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/web.css', 'resources/css/style.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-950 text-stone-100">
    <div class="relative isolate min-h-screen overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.25),_transparent_35%),linear-gradient(180deg,_#1c1917_0%,_#0c0a09_100%)]"></div>

        <header class="border-b border-white/10 bg-white/5 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide text-orange-300">Âm nhạc trực tuyến</a>

                <nav class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-white/10 px-4 py-2 text-stone-200 transition hover:border-orange-300 hover:text-orange-200">Bảng điều khiển</a>
                        <a href="{{ route('profile') }}" class="rounded-full border border-white/10 px-4 py-2 text-stone-200 transition hover:border-orange-300 hover:text-orange-200">Hồ sơ</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-full bg-orange-500 px-4 py-2 font-medium text-stone-950 transition hover:bg-orange-400">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-stone-200 transition hover:border-orange-300 hover:text-orange-200">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="rounded-full bg-orange-500 px-4 py-2 font-medium text-stone-950 transition hover:bg-orange-400">Đăng ký</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-6 py-10">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

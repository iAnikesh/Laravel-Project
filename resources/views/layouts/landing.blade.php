<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="GIS-enabled Management Information System for rural housing schemes — track, monitor, and allocate housing projects with transparency.">

        <title>{{ $title ?? config('app.name', 'RuralNest MIS') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased selection:bg-emerald-600 selection:text-white">
        <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-slate-900/80 backdrop-blur-lg">
            <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </span>
                    <div class="leading-tight">
                        <p class="text-sm font-bold text-white">{{ config('app.name', 'RuralNest MIS') }}</p>
                        <p class="text-xs text-emerald-200/80">GIS-enabled scheme management</p>
                    </div>
                </a>

                <div class="hidden items-center gap-8 text-sm font-medium text-slate-300 md:flex">
                    <a href="#features" class="transition hover:text-white">Features</a>
                    <a href="#schemes" class="transition hover:text-white">Schemes</a>
                    <a href="#how-it-works" class="transition hover:text-white">How it works</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-400">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden rounded-lg px-4 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white sm:inline-flex">
                            Sign in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-400">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="border-t border-slate-800 bg-slate-950 text-slate-400">
            <div class="mx-auto max-w-7xl px-5 py-12 sm:px-8">
                <div class="grid gap-10 md:grid-cols-3">
                    <div class="md:col-span-2">
                        <p class="text-lg font-semibold text-white">{{ config('app.name', 'RuralNest MIS') }}</p>
                        <p class="mt-3 max-w-lg text-sm leading-relaxed">
                            A Management Information System for rural housing programmes, integrating GIS to strengthen tracking, monitoring, allocation, and public accountability.
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-slate-500">Quick links</p>
                        <ul class="mt-4 space-y-2 text-sm">
                            <li><a href="#features" class="transition hover:text-emerald-400">Features</a></li>
                            <li><a href="#schemes" class="transition hover:text-emerald-400">Supported schemes</a></li>
                            @guest
                                <li><a href="{{ route('login') }}" class="transition hover:text-emerald-400">Sign in</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
                <div class="mt-10 border-t border-slate-800 pt-6 text-center text-xs">
                    &copy; {{ date('Y') }} {{ config('app.name', 'RuralNest MIS') }}. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>

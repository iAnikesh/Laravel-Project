<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RuralNest MIS') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
        <div class="flex min-h-screen">
            {{-- Brand panel --}}
            <aside class="relative hidden overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-blue-900 lg:flex lg:w-[42%] xl:w-[38%]">
                <div class="pointer-events-none absolute inset-0 opacity-30" aria-hidden="true">
                    <div class="absolute -left-20 top-20 h-72 w-72 rounded-full bg-blue-400 blur-3xl"></div>
                    <div class="absolute bottom-10 right-0 h-64 w-64 rounded-full bg-indigo-500 blur-3xl"></div>
                </div>

                <div class="relative z-10 flex flex-col justify-between p-10 xl:p-14">
                    <div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-white ring-1 ring-white/20 backdrop-blur">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h1 class="mt-8 text-3xl font-bold tracking-tight text-white xl:text-4xl">
                            {{ config('app.name', 'RuralNest MIS') }}
                        </h1>
                        <p class="mt-3 max-w-sm text-base leading-relaxed text-blue-100/90">
                            GIS-enabled management for rural housing schemes — register, track, and monitor housing programmes with transparency.
                        </p>
                    </div>

                    <ul class="space-y-4 text-sm text-blue-100/80">
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </span>
                            End-to-end encrypted sessions
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            Verified citizen identity
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </span>
                            Fast, paperless registration
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Form panel --}}
            <main class="flex flex-1 flex-col bg-slate-50">
                <div class="flex flex-1 flex-col justify-center px-5 py-10 sm:px-10 lg:px-14 xl:px-20">
                    {{-- Mobile branding --}}
                    <div class="mb-8 text-center lg:hidden">
                        <div class="mx-auto inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/25">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-medium text-slate-500">{{ config('app.name', 'RuralNest MIS') }}</p>
                    </div>

                    <div @class([
                        'mx-auto w-full',
                        'max-w-md' => ! $wide,
                        'max-w-3xl' => $wide,
                    ])>
                        {{ $slot }}
                    </div>
                </div>

                <footer class="px-5 pb-6 text-center text-xs text-slate-400 sm:px-10">
                    &copy; {{ date('Y') }} {{ config('app.name', 'RuralNest MIS') }}. All rights reserved.
                </footer>
            </main>
        </div>
    </body>
</html>

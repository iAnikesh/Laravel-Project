@props(['title' => null])
@php
    $pageTitle = $title ?? ($header ?? config('app.name', 'RuralNest MIS'));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $pageTitle }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50 relative min-h-screen" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
        {{-- Ambient Background Effects --}}
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
            <div class="absolute top-[20%] -right-[20%] w-[60%] h-[60%] rounded-full bg-teal-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[80%] h-[60%] rounded-full bg-blue-400/5 blur-[120px]"></div>
        </div>
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        @include('mis.partials.sidebar')

        <div class="flex min-h-screen flex-col lg:pl-64">
            @include('mis.partials.topbar')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('status'))
                    <x-mis.alert type="success" class="mb-6">{{ session('status') }}</x-mis.alert>
                @endif

                @if ($errors->any())
                    <x-mis.alert type="error" class="mb-6">
                        <p class="font-semibold">Please fix the following errors:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-mis.alert>
                @endif

                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>

<x-landing-layout :title="config('app.name', 'RuralNest MIS') . ' — Rural Housing Scheme Management'">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-900 pt-28 pb-20 sm:pt-36 sm:pb-28">
        <div class="pointer-events-none absolute inset-0 opacity-40" aria-hidden="true">
            <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-emerald-400 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-teal-500 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-2 lg:gap-16">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-300 ring-1 ring-emerald-500/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    GIS-integrated MIS platform
                </span>
                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-[3.25rem] lg:leading-[1.1]">
                    Track rural housing schemes with clarity and accountability
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-300">
                    A Management Information System built for programmes like <strong class="font-semibold text-white">Garib Awas Yojana</strong> — combining project data, beneficiary records, and geospatial maps to improve monitoring, allocation, and transparent implementation across villages and districts.
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-400">
                            Get started
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-white/10 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-white/15">
                            Sign in to portal
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-400">
                            Open dashboard
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    @endguest
                </div>
            </div>

            {{-- GIS map mockup --}}
            <div class="relative mx-auto w-full max-w-lg lg:max-w-none">
                <div class="rounded-2xl bg-slate-800/60 p-4 ring-1 ring-white/10 backdrop-blur sm:p-5">
                    <div class="mb-3 flex items-center justify-between text-xs text-slate-400">
                        <span class="font-medium text-emerald-300">Live scheme map</span>
                        <span class="rounded bg-slate-700/80 px-2 py-0.5">GIS layer</span>
                    </div>
                    <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-gradient-to-br from-emerald-900/80 to-slate-900">
                        <svg class="absolute inset-0 h-full w-full text-emerald-600/30" viewBox="0 0 400 300" aria-hidden="true">
                            <path fill="currentColor" d="M0 120 Q80 80 160 100 T320 90 L400 110 L400 300 L0 300 Z"/>
                            <path fill="currentColor" opacity="0.5" d="M0 180 Q100 150 200 170 T400 160 L400 300 L0 300 Z"/>
                        </svg>
                        @foreach ([['18%','22%'],['45%','35%'],['62%','28%'],['72%','55%'],['30%','58%'],['55%','68%']] as $pin)
                            <span class="absolute flex h-8 w-8 -translate-x-1/2 -translate-y-full items-center justify-center" style="left: {{ $pin[0] }}; top: {{ $pin[1] }};">
                                <span class="absolute h-8 w-8 animate-ping rounded-full bg-emerald-400/40"></span>
                                <span class="relative flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-white shadow-lg ring-2 ring-white/30">
                                    <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </span>
                            </span>
                        @endforeach
                        <div class="absolute bottom-3 left-3 right-3 flex gap-2">
                            <div class="flex-1 rounded-lg bg-slate-900/80 px-3 py-2 text-xs backdrop-blur">
                                <p class="text-slate-400">Active sites</p>
                                <p class="font-bold text-white">1,248</p>
                            </div>
                            <div class="flex-1 rounded-lg bg-slate-900/80 px-3 py-2 text-xs backdrop-blur">
                                <p class="text-slate-400">Completed</p>
                                <p class="font-bold text-emerald-400">892</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="relative z-10 -mt-8 mx-auto max-w-5xl px-5 sm:px-8">
        <div class="grid grid-cols-2 gap-4 rounded-2xl bg-white p-6 shadow-xl shadow-slate-900/10 ring-1 ring-slate-200 sm:grid-cols-4 sm:gap-6 sm:p-8">
            @foreach ([
                ['label' => 'Districts mapped', 'value' => '500+'],
                ['label' => 'Housing units tracked', 'value' => '2.4M'],
                ['label' => 'Schemes supported', 'value' => '12'],
                ['label' => 'Transparency score', 'value' => '98%'],
            ] as $stat)
                <div class="text-center sm:text-left">
                    <p class="text-2xl font-bold text-emerald-700 sm:text-3xl">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-xs font-medium text-slate-500 sm:text-sm">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Problem --}}
    <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8 sm:py-24">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Closing the gap in rural housing administration</h2>
            <p class="mt-5 text-lg leading-relaxed text-slate-600">
                Tracking schemes like Garib Awas Yojana often relies on fragmented spreadsheets and paper records. Without an integrated system, officials struggle to monitor progress, allocate resources fairly, and demonstrate transparency to citizens.
            </p>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="bg-slate-50 py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Built for end-to-end scheme management</h2>
                <p class="mx-auto mt-4 max-w-2xl text-slate-600">GIS, dashboards, and workflows in one platform — from beneficiary registration to project completion.</p>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    [
                        'title' => 'GIS mapping',
                        'desc' => 'Plot housing sites on interactive maps with district, block, and village boundaries for spatial analysis.',
                        'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                        'color' => 'emerald',
                    ],
                    [
                        'title' => 'Real-time monitoring',
                        'desc' => 'Track construction stages, fund releases, and deadlines with live status updates across all projects.',
                        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        'color' => 'teal',
                    ],
                    [
                        'title' => 'Smart allocation',
                        'desc' => 'Prioritize beneficiaries using eligibility rules, waitlists, and geographic equity across rural blocks.',
                        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        'color' => 'amber',
                    ],
                    [
                        'title' => 'Transparency & reports',
                        'desc' => 'Generate audit-ready reports and public dashboards to strengthen accountability and citizen trust.',
                        'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'color' => 'blue',
                    ],
                ] as $feature)
                    <article class="landing-card group">
                        <div @class([
                            'mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl',
                            'bg-emerald-100 text-emerald-700' => $feature['color'] === 'emerald',
                            'bg-teal-100 text-teal-700' => $feature['color'] === 'teal',
                            'bg-amber-100 text-amber-700' => $feature['color'] === 'amber',
                            'bg-blue-100 text-blue-700' => $feature['color'] === 'blue',
                        ])>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $feature['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $feature['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Schemes --}}
    <section id="schemes" class="mx-auto max-w-7xl px-5 py-20 sm:px-8 sm:py-24">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Supported housing schemes</h2>
                <p class="mt-3 max-w-xl text-slate-600">Central and state rural housing programmes managed through a single MIS framework.</p>
            </div>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <article class="landing-card border-emerald-200 ring-emerald-100">
                <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Flagship scheme</span>
                <h3 class="mt-4 text-xl font-bold text-slate-900">Garib Awas Yojana</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Pucca houses for rural families living in kutcha or dilapidated dwellings, with geo-tagged construction progress.</p>
            </article>
            <article class="landing-card">
                <span class="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">State programmes</span>
                <h3 class="mt-4 text-xl font-bold text-slate-900">State rural housing missions</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Configurable modules for state-specific targets, fund flows, and local body approvals.</p>
            </article>
            <article class="landing-card">
                <span class="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Allied schemes</span>
                <h3 class="mt-4 text-xl font-bold text-slate-900">Toilet &amp; livelihood linkages</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">Cross-scheme beneficiary matching for sanitation, electrification, and employment data.</p>
            </article>
        </div>
    </section>

    {{-- How it works --}}
    <section id="how-it-works" class="bg-gradient-to-b from-emerald-50 to-white py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">How the platform works</h2>
                <p class="mx-auto mt-4 max-w-2xl text-slate-600">From citizen registration to GIS-backed project delivery in four integrated steps.</p>
            </div>

            <ol class="mt-14 grid gap-8 md:grid-cols-4">
                @foreach ([
                    ['step' => '01', 'title' => 'Register & verify', 'desc' => 'Citizens and field officers capture beneficiary data with document validation.'],
                    ['step' => '02', 'title' => 'Allocate & approve', 'desc' => 'Eligibility checks and ward-level allocation based on scheme rules and quotas.'],
                    ['step' => '03', 'title' => 'Map & monitor', 'desc' => 'Sites geotagged on GIS layers; inspectors update construction milestones.'],
                    ['step' => '04', 'title' => 'Report & audit', 'desc' => 'Dashboards and exportable reports for administrators and public disclosure.'],
                ] as $item)
                    <li class="relative text-center md:text-left">
                        <span class="text-4xl font-extrabold text-emerald-200">{{ $item['step'] }}</span>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-7xl px-5 pb-24 sm:px-8">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-700 to-teal-800 px-8 py-14 text-center shadow-xl sm:px-16">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">Ready to strengthen rural housing delivery?</h2>
            <p class="mx-auto mt-4 max-w-2xl text-emerald-100">
                Join officials and citizens using GIS-enabled tracking for fairer allocation, faster monitoring, and transparent implementation.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-800 shadow-sm transition hover:bg-emerald-50">Create an account</a>
                    <a href="{{ route('login') }}" class="rounded-xl bg-emerald-600/50 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/30 transition hover:bg-emerald-600/70">Sign in</a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-800 shadow-sm transition hover:bg-emerald-50">Go to dashboard</a>
                @endguest
            </div>
        </div>
    </section>
</x-landing-layout>

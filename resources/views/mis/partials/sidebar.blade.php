@php
    $user = auth()->user();
    $role = is_object($user->role) ? $user->role->value : $user->role;

    $navActive = function (string $route): bool {
        return match ($route) {
            'dashboard' => request()->routeIs('dashboard'),
            'applications.index' => request()->routeIs('applications.*'),
            'gis.index' => request()->routeIs('gis.*'),
            'grievances.index' => request()->routeIs('grievances.*'),
            'search' => request()->routeIs('search'),
            'reports.index' => request()->routeIs('reports.*'),
            'master.districts.index' => request()->routeIs('master.districts.*'),
            'master.schemes.index' => request()->routeIs('master.schemes.*'),
            'audit-logs.index' => request()->routeIs('audit-logs.*'),
            'notifications.index' => request()->routeIs('notifications.*'),
            'modules.index' => request()->routeIs('modules.*'),
            default => request()->routeIs($route),
        };
    };

    $nav = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'Applications', 'route' => 'applications.index', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'GIS Map', 'route' => 'gis.index', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'Grievances', 'route' => 'grievances.index', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'Search', 'route' => 'search', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'Reports', 'route' => 'reports.index', 'icon' => 'M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z', 'roles' => ['admin', 'officer']],
        ['label' => 'Master Data', 'route' => 'master.districts.index', 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4', 'roles' => ['admin']],
        ['label' => 'Schemes', 'route' => 'master.schemes.index', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'roles' => ['admin']],
        ['label' => 'Audit Logs', 'route' => 'audit-logs.index', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'roles' => ['admin']],
        ['label' => 'Notifications', 'route' => 'notifications.index', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'roles' => ['admin', 'officer', 'customer']],
        ['label' => 'MIS Modules', 'route' => 'modules.index', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'roles' => ['admin', 'officer', 'customer']],
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-white/10 bg-slate-900/95 backdrop-blur-xl shadow-2xl transition-transform duration-300 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-16 shrink-0 items-center justify-between gap-3 border-b border-white/10 px-4">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3 group" @click="sidebarOpen = false">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white shadow-lg shadow-emerald-500/20 transition-transform group-hover:scale-105">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </span>
            <div class="min-w-0 leading-tight">
                <p class="truncate text-sm font-bold text-white">{{ config('app.name', 'Rural Housing MIS') }}</p>
                <p class="text-[10px] uppercase tracking-wider text-emerald-400">Management System</p>
            </div>
        </a>
        <button type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white lg:hidden" @click="sidebarOpen = false" aria-label="Close menu">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-4">
        @foreach ($nav as $item)
            @if (in_array($role, $item['roles'], true))
                @php $active = $navActive($item['route']); @endphp
                <a
                    href="{{ route($item['route']) }}"
                    @click="sidebarOpen = false"
                    @class([
                        'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-300',
                        'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/20 translate-x-1' => $active,
                        'text-slate-400 hover:bg-white/10 hover:text-white hover:translate-x-1' => ! $active,
                    ])
                >
                    <svg class="h-5 w-5 shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"></path></svg>
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach

        @if ($user->isAdmin())
            <div class="mt-4 border-t border-slate-800 pt-4">
                <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-wider text-slate-500">Administration</p>
                <a
                    href="{{ route('admin.officers.create') }}"
                    @click="sidebarOpen = false"
                    @class([
                        'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-300',
                        'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/20 translate-x-1' => request()->routeIs('admin.officers.*'),
                        'text-slate-400 hover:bg-white/10 hover:text-white hover:translate-x-1' => ! request()->routeIs('admin.officers.*'),
                    ])
                >
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manage Officers
                </a>
            </div>
        @endif
    </nav>

    <div class="shrink-0 border-t border-slate-800 p-4">
        <p class="truncate text-sm font-medium text-white">{{ $user->name }}</p>
        <p class="text-xs capitalize text-slate-400">{{ str_replace('_', ' ', $role) }}</p>
    </div>
</aside>

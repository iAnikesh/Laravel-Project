<header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-3 border-b border-white/40 bg-white/70 backdrop-blur-xl px-4 shadow-sm sm:px-6">
    <button
        type="button"
        class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 lg:hidden"
        @click="sidebarOpen = true"
        aria-label="Open menu"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>

    <div class="min-w-0 flex-1">
        @isset($header)
            <h1 class="truncate text-lg font-semibold text-slate-900">{{ $header }}</h1>
        @endisset
        @isset($subheader)
            <p class="truncate text-sm text-slate-500">{{ $subheader }}</p>
        @endisset
    </div>

    <div class="flex shrink-0 items-center gap-1 sm:gap-2">
        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
        <a href="{{ route('notifications.index') }}" class="relative rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" title="Notifications">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            @if ($unread > 0)
                <span class="absolute right-0.5 top-0.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-gradient-to-r from-red-500 to-rose-500 px-1 text-[10px] font-bold text-white shadow-sm animate-pulse">{{ $unread > 9 ? '9+' : $unread }}</span>
            @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="hidden rounded-xl px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-slate-100/80 hover:text-slate-900 sm:inline-flex">Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="rounded-xl px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-slate-100/80 hover:text-slate-900">Logout</button>
        </form>
    </div>
</header>

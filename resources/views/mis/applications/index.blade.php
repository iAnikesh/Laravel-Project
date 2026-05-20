<x-mis-layout>
    <x-slot name="header">Housing Applications</x-slot>
    <x-slot name="subheader">Track, filter, and manage beneficiary housing applications</x-slot>

    <div class="mis-card mb-6 relative overflow-visible z-20">
        <div class="mis-card-body p-5">
            <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="mis-label mb-1.5 text-xs text-slate-500 uppercase tracking-wider">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Application # or name" class="mis-input pl-10">
                    </div>
                </div>
                <div>
                    <label class="mis-label mb-1.5 text-xs text-slate-500 uppercase tracking-wider">Status</label>
                    <select name="status" class="mis-input">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mis-label mb-1.5 text-xs text-slate-500 uppercase tracking-wider">Scheme</label>
                    <select name="scheme_id" class="mis-input">
                        <option value="">All schemes</option>
                        @foreach ($schemes as $scheme)
                            <option value="{{ $scheme->id }}" @selected(request('scheme_id') == $scheme->id)>{{ $scheme->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-wrap gap-2 sm:col-span-2 lg:col-span-4">
                    <button type="submit" class="mis-btn-primary">Apply filters</button>
                    <a href="{{ route('applications.index') }}" class="mis-btn-secondary">Reset</a>
                    <a href="{{ route('applications.create') }}" class="mis-btn-primary sm:ml-auto">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New application
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mis-card z-10 relative">
        <div class="mis-table-wrap m-0 border-0 rounded-b-none bg-transparent shadow-none backdrop-blur-none">
            <table class="mis-table">
                <thead>
                    <tr>
                        <th>Application #</th>
                        <th>Beneficiary</th>
                        <th class="hidden md:table-cell">Scheme</th>
                        <th class="hidden lg:table-cell">Location</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 bg-white/20">
                    @forelse ($applications as $application)
                        <tr class="group cursor-pointer" onclick="window.location='{{ route('applications.show', $application) }}'">
                            <td class="align-middle">
                                <a href="{{ route('applications.show', $application) }}" class="mis-link text-[15px] block truncate" onclick="event.stopPropagation()">{{ $application->application_number }}</a>
                                <p class="mt-1 text-xs text-slate-500 md:hidden">{{ $application->scheme->name }}</p>
                            </td>
                            <td class="font-medium text-slate-900 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-slate-600">{{ substr($application->beneficiary->name, 0, 1) }}</span>
                                    </div>
                                    {{ $application->beneficiary->name }}
                                </div>
                            </td>
                            <td class="hidden md:table-cell align-middle text-slate-600 font-medium">{{ $application->scheme->name }}</td>
                            <td class="hidden lg:table-cell text-slate-500 align-middle">{{ $application->village->name }}</td>
                            <td class="align-middle w-48">
                                <div class="flex items-center gap-3">
                                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200/60 shadow-inner">
                                        <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 shadow-[0_0_8px_rgba(52,211,153,0.5)]" style="width: {{ $application->completion_percentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold w-9">{{ $application->completion_percentage }}%</span>
                                </div>
                            </td>
                            <td class="align-middle"><x-mis.status-badge :status="$application->status" /></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <p class="text-slate-500 font-medium">No applications found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($applications->hasPages())
            <div class="border-t border-white/40 bg-white/40 px-6 py-4">{{ $applications->links() }}</div>
        @endif
    </div>
</x-mis-layout>

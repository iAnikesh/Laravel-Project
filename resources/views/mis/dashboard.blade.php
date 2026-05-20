<x-mis-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="subheader">Overview of rural housing scheme operations</x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-mis.stat-card label="Total applications" :value="$stats['total_applications']" />
        <x-mis.stat-card label="Pending review" :value="$stats['pending_review']" color="amber" />
        <x-mis.stat-card label="In progress" :value="$stats['in_progress']" color="teal" />
        <x-mis.stat-card label="Completed" :value="$stats['completed']" color="blue" />
    </div>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-mis.stat-card label="Open grievances" :value="$stats['open_grievances']" color="red" />
        <x-mis.stat-card label="Active schemes" :value="$stats['active_schemes']" />
        @if (auth()->user()->isStaff())
            <x-mis.stat-card label="Total expenditure (₹)" :value="number_format($stats['total_expenditure'], 0)" color="slate" />
        @endif
        @if (auth()->user()->isAdmin())
            <x-mis.stat-card label="Registered beneficiaries" :value="$stats['beneficiaries']" color="blue" />
        @endif
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="mis-card lg:col-span-2">
            <div class="mis-card-header">
                <h2 class="font-semibold text-slate-900">Recent applications</h2>
                <a href="{{ route('applications.index') }}" class="mis-link text-sm">View all</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentApplications as $application)
                    <a href="{{ route('applications.show', $application) }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 transition hover:bg-slate-50 sm:px-6">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-slate-900">{{ $application->application_number }}</p>
                            <p class="truncate text-sm text-slate-500">{{ $application->beneficiary->name }} · {{ $application->scheme->name }}</p>
                        </div>
                        <x-mis.status-badge :status="$application->status" />
                    </a>
                @empty
                    <p class="px-6 py-10 text-center text-sm text-slate-500">No applications yet. <a href="{{ route('applications.create') }}" class="mis-link">Create one</a></p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="mis-card">
                <div class="mis-card-body">
                    <h2 class="font-semibold text-slate-900">Status breakdown</h2>
                    <ul class="mt-4 space-y-3">
                        @foreach (\App\Enums\ApplicationStatus::cases() as $status)
                            <li class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">{{ $status->label() }}</span>
                                <span class="font-semibold tabular-nums text-slate-900">{{ $statusBreakdown[$status->value] ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if (auth()->user()->isAdmin() && $recentActivity->isNotEmpty())
                <div class="mis-card">
                    <div class="mis-card-body">
                        <h2 class="font-semibold text-slate-900">Recent activity</h2>
                        <ul class="mt-4 space-y-3">
                            @foreach ($recentActivity as $log)
                                <li class="text-sm">
                                    <p class="text-slate-800">{{ $log->description }}</p>
                                    <p class="text-xs text-slate-400">{{ $log->user?->name ?? 'System' }} · {{ $log->created_at->diffForHumans() }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('applications.create') }}" class="mis-btn-primary">New application</a>
        <a href="{{ route('gis.index') }}" class="mis-btn-secondary">Open GIS map</a>
        <a href="{{ route('modules.index') }}" class="mis-btn-secondary">MIS modules</a>
    </div>
</x-mis-layout>

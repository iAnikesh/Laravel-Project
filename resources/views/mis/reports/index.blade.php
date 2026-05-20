<x-mis-layout>
    <x-slot name="header">Reports</x-slot>
    <x-slot name="subheader">Scheme-wise summaries and data export</x-slot>

    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <x-mis.stat-card label="Total applications" :value="$summary['total']" />
        <x-mis.stat-card label="Approved" :value="$summary['approved']" color="emerald" />
        <x-mis.stat-card label="Completed" :value="$summary['completed']" color="blue" />
        <x-mis.stat-card label="Rejected" :value="$summary['rejected']" color="red" />
    </div>

    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('reports.export') }}" class="mis-btn-primary w-auto px-5">Export all (CSV)</a>
        @foreach ($schemes as $scheme)
            <a href="{{ route('reports.export', ['scheme_id' => $scheme->id]) }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">{{ $scheme->code }} CSV</a>
        @endforeach
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="font-semibold text-slate-900">Applications by scheme & status</h2>
        <div class="mt-4 space-y-6">
            @forelse ($byScheme as $schemeName => $rows)
                <div>
                    <h3 class="text-sm font-semibold text-emerald-700">{{ $schemeName }}</h3>
                    <ul class="mt-2 flex flex-wrap gap-3 text-sm text-slate-600">
                        @foreach ($rows as $row)
                            <li>{{ $row->status }}: <strong>{{ $row->total }}</strong></li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-slate-500">No report data available.</p>
            @endforelse
        </div>
    </div>
</x-mis-layout>

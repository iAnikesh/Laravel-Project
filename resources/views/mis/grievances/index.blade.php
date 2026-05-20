<x-mis-layout>
    <x-slot name="header">Grievances</x-slot>
    <x-slot name="subheader">Complaint tracking and resolution</x-slot>

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <form method="GET">
            <label class="mis-label">Filter by status</label>
            <select name="status" class="mis-input mt-1.5 w-48" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('grievances.create') }}" class="mis-btn-primary">Submit grievance</a>
    </div>

    <div class="space-y-3">
        @forelse ($grievances as $grievance)
            <a href="{{ route('grievances.show', $grievance) }}" class="mis-card block transition hover:border-emerald-200 hover:shadow-md">
                <div class="flex flex-wrap items-start justify-between gap-4 p-5 sm:p-6">
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-900">{{ $grievance->subject }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $grievance->reference_number }} · {{ $grievance->user->name }}</p>
                    </div>
                    <x-mis.status-badge :status="$grievance->status" />
                </div>
            </a>
        @empty
            <div class="mis-card p-10 text-center text-slate-500">No grievances found.</div>
        @endforelse
    </div>

    @if ($grievances->hasPages())
        <div class="mt-6">{{ $grievances->links() }}</div>
    @endif
</x-mis-layout>

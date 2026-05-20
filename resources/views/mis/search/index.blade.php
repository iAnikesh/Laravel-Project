<x-mis-layout>
    <x-slot name="header">Search</x-slot>
    <x-slot name="subheader">Find applications, grievances, and beneficiaries by name or ID</x-slot>

    <form method="GET" class="mb-8 flex gap-3">
        <input type="search" name="q" value="{{ $query }}" placeholder="Search by application #, name, user ID, Aadhaar..." class="mis-input flex-1" minlength="2">
        <button type="submit" class="mis-btn-primary w-auto px-6">Search</button>
    </form>

    @if (strlen($query) >= 2)
        <div class="grid gap-8 lg:grid-cols-3">
            <section>
                <h2 class="font-semibold text-slate-900">Applications ({{ $results['applications']->count() }})</h2>
                <ul class="mt-3 space-y-2">
                    @forelse ($results['applications'] as $app)
                        <li><a href="{{ route('applications.show', $app) }}" class="text-sm font-medium text-emerald-600 hover:underline">{{ $app->application_number }} — {{ $app->beneficiary->name }}</a></li>
                    @empty
                        <li class="text-sm text-slate-500">No matches</li>
                    @endforelse
                </ul>
            </section>
            <section>
                <h2 class="font-semibold text-slate-900">Grievances ({{ $results['grievances']->count() }})</h2>
                <ul class="mt-3 space-y-2">
                    @forelse ($results['grievances'] as $g)
                        <li><a href="{{ route('grievances.show', $g) }}" class="text-sm font-medium text-emerald-600 hover:underline">{{ $g->reference_number }} — {{ $g->subject }}</a></li>
                    @empty
                        <li class="text-sm text-slate-500">No matches</li>
                    @endforelse
                </ul>
            </section>
            @if (auth()->user()->isStaff())
                <section>
                    <h2 class="font-semibold text-slate-900">Beneficiaries ({{ $results['beneficiaries']->count() }})</h2>
                    <ul class="mt-3 space-y-2">
                        @forelse ($results['beneficiaries'] as $b)
                            <li class="text-sm text-slate-700">{{ $b->name }} ({{ $b->unique_user_id ?? $b->email }})</li>
                        @empty
                            <li class="text-sm text-slate-500">No matches</li>
                        @endforelse
                    </ul>
                </section>
            @endif
        </div>
    @elseif ($query)
        <p class="text-slate-500">Enter at least 2 characters to search.</p>
    @endif
</x-mis-layout>

<x-mis-layout>
    <x-slot name="header">{{ $grievance->reference_number }}</x-slot>
    <x-slot name="subheader">{{ $grievance->subject }}</x-slot>

    <div class="max-w-3xl space-y-6">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <x-mis.status-badge :status="$grievance->status" />
                <span class="text-sm text-slate-500">{{ $grievance->created_at->format('d M Y H:i') }}</span>
            </div>
            <p class="mt-4 text-slate-700">{{ $grievance->description }}</p>
            @if ($grievance->admin_response)
                <div class="mt-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-900">
                    <p class="font-semibold">Official response</p>
                    <p class="mt-1">{{ $grievance->admin_response }}</p>
                </div>
            @endif
        </div>

        @can('respond', $grievance)
            <form method="POST" action="{{ route('grievances.respond', $grievance) }}" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                <h2 class="font-semibold text-slate-900">Respond to grievance</h2>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mis-label">Response *</label>
                        <textarea name="admin_response" class="mis-input mt-1" rows="4" required>{{ old('admin_response', $grievance->admin_response) }}</textarea>
                    </div>
                    <div>
                        <label class="mis-label">Status *</label>
                        <select name="status" class="mis-input mt-1" required>
                            @foreach (\App\Enums\GrievanceStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected($grievance->status === $status)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="mis-btn-primary mt-4 w-auto px-6">Save response</button>
            </form>
        @endcan
    </div>
</x-mis-layout>

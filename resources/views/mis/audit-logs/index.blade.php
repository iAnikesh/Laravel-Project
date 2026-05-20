<x-mis-layout>
    <x-slot name="header">Audit trail</x-slot>
    <x-slot name="subheader">Who did what and when — system change logs</x-slot>

    <form method="GET" class="mb-6">
        <input type="text" name="action" value="{{ request('action') }}" placeholder="Filter by action..." class="mis-input w-64">
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">When</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">User</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Action</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Description</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($logs as $log)
                    <tr>
                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $log->action }}</td>
                        <td class="px-4 py-3">{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3">{{ $logs->links() }}</div>
    </div>
</x-mis-layout>

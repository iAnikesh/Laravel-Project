<x-mis-layout>
    <x-slot name="header">Field Officers</x-slot>
    <x-slot name="subheader">Manage field officer accounts and permissions</x-slot>

    <div class="mb-6 flex flex-wrap gap-4 sm:items-center sm:justify-between">
        <div class="relative max-w-sm flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" placeholder="Search officers..." class="mis-input pl-10" disabled>
        </div>
        <a href="{{ route('admin.officers.create') }}" class="mis-btn-primary shrink-0">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Officer
        </a>
    </div>

    <div class="mis-card">
        <div class="mis-table-wrap">
            <table class="mis-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 bg-white/20">
                    @forelse ($officers as $officer)
                        <tr class="group">
                            <td class="font-medium text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 overflow-hidden rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center shrink-0">
                                        <span class="text-sm font-bold text-emerald-700 uppercase">{{ substr($officer->name, 0, 2) }}</span>
                                    </div>
                                    {{ $officer->name }}
                                </div>
                            </td>
                            <td class="text-slate-500">{{ $officer->email }}</td>
                            <td class="text-slate-500">{{ $officer->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <button class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">No officers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($officers->hasPages())
            <div class="border-t border-white/40 bg-white/40 px-6 py-4">{{ $officers->links() }}</div>
        @endif
    </div>
</x-mis-layout>

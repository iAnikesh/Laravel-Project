<x-mis-layout>
    <x-slot name="header">Master Data — Districts</x-slot>
    <x-slot name="subheader">Administrative hierarchy: districts, blocks, and villages</x-slot>

    <div class="mb-6 flex justify-between">
        <p class="text-sm text-slate-600">{{ $districts->total() }} districts registered</p>
        <a href="{{ route('master.districts.create') }}" class="mis-btn-primary w-auto px-5">Add district</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50"><tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Code</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Name</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">State</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Blocks</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($districts as $district)
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs">{{ $district->code }}</td>
                        <td class="px-4 py-3 font-medium">{{ $district->name }}</td>
                        <td class="px-4 py-3">{{ $district->state }}</td>
                        <td class="px-4 py-3">{{ $district->blocks_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3">{{ $districts->links() }}</div>
    </div>
</x-mis-layout>

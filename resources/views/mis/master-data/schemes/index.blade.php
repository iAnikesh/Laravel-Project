<x-mis-layout>
    <x-slot name="header">Housing Schemes</x-slot>
    <x-slot name="subheader">Central and state rural housing programmes</x-slot>

    <div class="mb-6 flex justify-between">
        <a href="{{ route('master.schemes.create') }}" class="mis-btn-primary w-auto px-5">Add scheme</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @foreach ($schemes as $scheme)
            <article class="landing-card">
                <div class="flex items-start justify-between">
                    <h3 class="font-bold text-slate-900">{{ $scheme->name }}</h3>
                    <span class="rounded bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">{{ $scheme->code }}</span>
                </div>
                <p class="mt-2 text-sm text-slate-600">{{ Str::limit($scheme->description, 120) }}</p>
                <dl class="mt-4 grid grid-cols-2 gap-2 text-xs text-slate-500">
                    <div><dt>Budget</dt><dd class="font-semibold text-slate-800">₹{{ number_format($scheme->budget_allocated, 0) }}</dd></div>
                    <div><dt>Applications</dt><dd class="font-semibold text-slate-800">{{ $scheme->housing_applications_count }}</dd></div>
                </dl>
            </article>
        @endforeach
    </div>
    <div class="mt-4">{{ $schemes->links() }}</div>
</x-mis-layout>

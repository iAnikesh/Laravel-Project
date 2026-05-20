@props(['type' => 'success'])

<div {{ $attributes->merge(['class' => 'rounded-lg px-4 py-3 text-sm ring-1 '.match($type) {
    'success' => 'bg-emerald-50 text-emerald-900 ring-emerald-200',
    'error' => 'bg-red-50 text-red-900 ring-red-200',
    'info' => 'bg-blue-50 text-blue-900 ring-blue-200',
    'warning' => 'bg-amber-50 text-amber-900 ring-amber-200',
    default => 'bg-slate-50 text-slate-900 ring-slate-200',
}]) }} role="alert">
    {{ $slot }}
</div>

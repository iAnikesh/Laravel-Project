@props(['label', 'value', 'color' => 'emerald'])

<div {{ $attributes->merge(['class' => 'mis-card p-5']) }}>
    <p @class([
        'text-2xl font-bold tabular-nums tracking-tight',
        'text-emerald-700' => $color === 'emerald',
        'text-blue-700' => $color === 'blue',
        'text-amber-700' => $color === 'amber',
        'text-teal-700' => $color === 'teal',
        'text-red-700' => $color === 'red',
        'text-slate-700' => $color === 'slate',
    ])>{{ $value }}</p>
    <p class="mt-1.5 text-sm font-medium text-slate-500">{{ $label }}</p>
</div>

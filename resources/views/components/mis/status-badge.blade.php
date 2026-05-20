@props(['status'])

@php
    $label = method_exists($status, 'label') ? $status->label() : (string) $status;
    $classes = match (method_exists($status, 'color') ? $status->color() : 'slate') {
        'emerald' => 'mis-badge-emerald',
        'blue' => 'mis-badge-blue',
        'amber' => 'mis-badge-amber',
        'teal' => 'mis-badge-teal',
        'red' => 'mis-badge-red',
        'green' => 'mis-badge-green',
        default => 'mis-badge-slate',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $label }}
</span>

@props([
    'label',
    'name',
    'type' => 'text',
    'required' => false,
    'optional' => false,
    'autocomplete' => null,
    'placeholder' => null,
])

@php
    $wrapperClass = $attributes->get('class', 'space-y-1.5');
    $inputAttributes = $attributes->except('class');
@endphp

<div class="{{ $wrapperClass }}">
    <label for="{{ $name }}" class="auth-label">
        {{ $label }}
        @if ($required)
            <span class="text-blue-600" aria-hidden="true">*</span>
        @elseif ($optional)
            <span class="font-normal text-slate-400">(optional)</span>
        @endif
    </label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if ($required) required @endif
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        value="{{ old($name) }}"
        {{ $inputAttributes->merge(['class' => 'auth-input']) }}
    />
    <x-input-error :messages="$errors->get($name)" class="auth-error" />
</div>

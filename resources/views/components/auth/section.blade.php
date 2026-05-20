@props([
    'title',
    'step',
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'auth-section']) }}>
    <div class="auth-section-header">
        <span class="auth-section-step" aria-hidden="true">{{ $step }}</span>
        <div>
            <h3 class="auth-section-title">{{ $title }}</h3>
            @if ($description)
                <p class="auth-section-description">{{ $description }}</p>
            @endif
        </div>
    </div>
    <div class="auth-section-body">
        {{ $slot }}
    </div>
</section>

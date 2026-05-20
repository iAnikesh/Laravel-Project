<x-guest-layout>
    <x-auth-session-status class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-800 ring-1 ring-green-200" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Welcome back</h2>
        <p class="mt-2 text-sm text-slate-500">Sign in to continue to your citizen dashboard.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-auth.field
            label="Email address"
            name="email"
            type="email"
            :required="true"
            autocomplete="username"
            placeholder="you@example.com"
            autofocus
        />

        <x-auth.field
            label="Password"
            name="password"
            type="password"
            :required="true"
            autocomplete="current-password"
            placeholder="Enter your password"
        />

        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2.5">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-600"
                >
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 transition-colors hover:text-blue-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="auth-btn-primary mt-2">
            {{ __('Sign in') }}
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-600">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="auth-link">{{ __('Create one') }}</a>
    </p>
</x-guest-layout>

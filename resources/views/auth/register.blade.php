<x-guest-layout wide>
    <div class="mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Citizen registration</h2>
        <p class="mt-2 text-sm text-slate-500">Complete each section below. Fields marked with <span class="text-blue-600">*</span> are required.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <x-auth.section step="1" title="Personal information" description="Your identity and contact details.">
            <x-auth.field label="Full name" name="name" :required="true" autocomplete="name" class="md:col-span-1" autofocus />
            <x-auth.field label="Email address" name="email" type="email" :required="true" autocomplete="username" />
            <x-auth.field label="Phone number" name="phone" type="tel" :optional="true" autocomplete="tel" placeholder="10-digit mobile" />
            <x-auth.field label="Aadhaar number" name="aadhaar_number" :optional="true" placeholder="XXXX XXXX XXXX" />
        </x-auth.section>

        <x-auth.section step="2" title="Location details" description="Where you currently reside.">
            <x-auth.field label="Address line 1" name="address_1" :optional="true" class="md:col-span-2" placeholder="House / building, street" />
            <x-auth.field label="Address line 2" name="address_2" :optional="true" class="md:col-span-2" placeholder="Area, landmark (optional)" />
            <x-auth.field label="City" name="city" :optional="true" />
            <x-auth.field label="Pin code" name="pin_code" :optional="true" placeholder="6-digit PIN" />
            <x-auth.field label="District" name="district" :optional="true" />
            <x-auth.field label="State" name="state" :optional="true" />
        </x-auth.section>

        <x-auth.section step="3" title="Bank details" description="For benefit disbursement, if applicable.">
            <x-auth.field label="Account number" name="bank_account_number" :optional="true" class="md:col-span-2" />
            <x-auth.field label="IFSC code" name="bank_ifsc_code" :optional="true" placeholder="e.g. SBIN0001234" />
            <x-auth.field label="Branch name" name="bank_branch" :optional="true" />
        </x-auth.section>

        <x-auth.section step="4" title="Security" description="Choose a strong password for your account.">
            <x-auth.field label="Password" name="password" type="password" :required="true" autocomplete="new-password" />
            <x-auth.field label="Confirm password" name="password_confirmation" type="password" :required="true" autocomplete="new-password" />
        </x-auth.section>

        <div class="rounded-xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
            <button type="submit" class="auth-btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Submit registration') }}
            </button>
        </div>
    </form>

    <p class="mt-8 text-center text-sm text-slate-600">
        {{ __('Already registered?') }}
        <a href="{{ route('login') }}" class="auth-link">{{ __('Sign in') }}</a>
    </p>
</x-guest-layout>

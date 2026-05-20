<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="unique_user_id" :value="__('User ID')" />
                <x-text-input id="unique_user_id" type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" :value="$user->unique_user_id ?? 'Not assigned'" disabled readonly />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" :value="$user->email" disabled readonly />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="aadhaar_number" :value="__('Aadhaar Number')" />
                <x-text-input id="aadhaar_number" name="aadhaar_number" type="text" class="mt-1 block w-full" :value="old('aadhaar_number', $user->aadhaar_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('aadhaar_number')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="address_1" :value="__('Address Line 1')" />
                <x-text-input id="address_1" name="address_1" type="text" class="mt-1 block w-full" :value="old('address_1', $user->address_1)" />
                <x-input-error class="mt-2" :messages="$errors->get('address_1')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="address_2" :value="__('Address Line 2')" />
                <x-text-input id="address_2" name="address_2" type="text" class="mt-1 block w-full" :value="old('address_2', $user->address_2)" />
                <x-input-error class="mt-2" :messages="$errors->get('address_2')" />
            </div>

            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div>
                <x-input-label for="pin_code" :value="__('PIN Code')" />
                <x-text-input id="pin_code" name="pin_code" type="text" class="mt-1 block w-full" :value="old('pin_code', $user->pin_code)" />
                <x-input-error class="mt-2" :messages="$errors->get('pin_code')" />
            </div>

            <div>
                <x-input-label for="district" :value="__('District')" />
                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district', $user->district)" />
                <x-input-error class="mt-2" :messages="$errors->get('district')" />
            </div>

            <div>
                <x-input-label for="state" :value="__('State')" />
                <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" />
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
            </div>

            <div class="md:col-span-2 mt-4">
                <h3 class="text-md font-medium text-gray-900 border-b pb-2 mb-4">{{ __('Bank Details') }}</h3>
            </div>

            <div>
                <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
                <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number', $user->bank_account_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
            </div>

            <div>
                <x-input-label for="bank_ifsc_code" :value="__('IFSC Code')" />
                <x-text-input id="bank_ifsc_code" name="bank_ifsc_code" type="text" class="mt-1 block w-full" :value="old('bank_ifsc_code', $user->bank_ifsc_code)" />
                <x-input-error class="mt-2" :messages="$errors->get('bank_ifsc_code')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="bank_branch" :value="__('Bank Branch')" />
                <x-text-input id="bank_branch" name="bank_branch" type="text" class="mt-1 block w-full" :value="old('bank_branch', $user->bank_branch)" />
                <x-input-error class="mt-2" :messages="$errors->get('bank_branch')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

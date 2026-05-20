<x-mis-layout>
    <x-slot name="header">Profile</x-slot>
    <x-slot name="subheader">Manage your account information and security</x-slot>

    <div class="mx-auto max-w-3xl space-y-6">
        <div class="mis-card">
            <div class="mis-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="mis-card">
            <div class="mis-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="mis-card">
            <div class="mis-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-mis-layout>

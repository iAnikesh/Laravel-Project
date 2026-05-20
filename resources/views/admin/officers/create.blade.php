<x-mis-layout>
    <x-slot name="header">Create field officer</x-slot>
    <x-slot name="subheader">Add a new officer account with review permissions</x-slot>

    <div class="mx-auto max-w-xl">
        <form method="POST" action="{{ route('admin.officers.store') }}" class="mis-card relative overflow-hidden">
            <!-- Decorative gradient orb -->
            <div class="absolute -top-24 -right-24 h-48 w-48 rounded-full bg-emerald-400/20 blur-[60px] pointer-events-none"></div>
            
            <div class="mis-card-body space-y-6 relative z-10">
                @csrf

                <div class="space-y-1">
                    <label for="name" class="mis-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mis-input" placeholder="e.g. John Doe">
                    <x-input-error :messages="$errors->get('name')" class="mis-error" />
                </div>

                <div class="space-y-1">
                    <label for="email" class="mis-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mis-input" placeholder="officer@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mis-error" />
                </div>

                <div class="space-y-1">
                    <label for="password" class="mis-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="mis-input" placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mis-error" />
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="mis-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mis-input" placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mis-error" />
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-white/40 mt-6">
                    <button type="submit" class="mis-btn-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create officer
                    </button>
                    <a href="{{ route('admin.officers.index') }}" class="mis-btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-mis-layout>

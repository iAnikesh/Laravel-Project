<x-mis-layout>
    <x-slot name="header">Add district</x-slot>

    <form method="POST" action="{{ route('master.districts.store') }}" class="max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="space-y-4">
            <div><label class="mis-label">Name *</label><input type="text" name="name" class="mis-input mt-1" required value="{{ old('name') }}"></div>
            <div><label class="mis-label">Code *</label><input type="text" name="code" class="mis-input mt-1" required value="{{ old('code') }}"></div>
            <div><label class="mis-label">State *</label><input type="text" name="state" class="mis-input mt-1" required value="{{ old('state', 'Uttar Pradesh') }}"></div>
        </div>
        <button type="submit" class="mis-btn-primary mt-6 w-auto px-6">Create</button>
    </form>
</x-mis-layout>

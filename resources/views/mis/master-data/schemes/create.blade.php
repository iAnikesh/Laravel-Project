<x-mis-layout>
    <x-slot name="header">Add housing scheme</x-slot>

    <form method="POST" action="{{ route('master.schemes.store') }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div class="md:col-span-2"><label class="mis-label">Scheme name *</label><input type="text" name="name" class="mis-input mt-1" required value="{{ old('name') }}"></div>
            <div><label class="mis-label">Code *</label><input type="text" name="code" class="mis-input mt-1" required value="{{ old('code') }}"></div>
            <div><label class="mis-label">Category *</label><input type="text" name="category" class="mis-input mt-1" required value="{{ old('category', 'central') }}"></div>
            <div class="md:col-span-2"><label class="mis-label">Description</label><textarea name="description" class="mis-input mt-1" rows="3">{{ old('description') }}</textarea></div>
            <div><label class="mis-label">Budget allocated (₹) *</label><input type="number" step="0.01" name="budget_allocated" class="mis-input mt-1" required value="{{ old('budget_allocated', 0) }}"></div>
            <div><label class="mis-label">Start date</label><input type="date" name="start_date" class="mis-input mt-1" value="{{ old('start_date') }}"></div>
            <div><label class="mis-label">End date</label><input type="date" name="end_date" class="mis-input mt-1" value="{{ old('end_date') }}"></div>
        </div>
        <button type="submit" class="mis-btn-primary mt-6 w-auto px-6">Create scheme</button>
    </form>
</x-mis-layout>

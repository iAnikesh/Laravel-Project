<x-mis-layout>
    <x-slot name="header">Submit grievance</x-slot>

    <form method="POST" action="{{ route('grievances.store') }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="mis-label">Related application (optional)</label>
                <select name="housing_application_id" class="mis-input mt-1">
                    <option value="">None</option>
                    @foreach ($applications as $app)
                        <option value="{{ $app->id }}">{{ $app->application_number }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mis-label">Subject *</label>
                <input type="text" name="subject" class="mis-input mt-1" required value="{{ old('subject') }}">
            </div>
            <div>
                <label class="mis-label">Description *</label>
                <textarea name="description" rows="5" class="mis-input mt-1" required>{{ old('description') }}</textarea>
            </div>
        </div>
        <button type="submit" class="mis-btn-primary mt-6 w-auto px-6">Submit</button>
    </form>
</x-mis-layout>

<x-mis-layout>
    <x-slot name="header">Edit application</x-slot>
    <x-slot name="subheader">{{ $application->application_number }}</x-slot>

    <form method="POST" action="{{ route('applications.update', $application) }}" class="mis-card mx-auto max-w-3xl">
        <div class="mis-card-body">
            @csrf
            @method('PATCH')
            @include('mis.applications._form', ['application' => $application, 'schemes' => $schemes, 'villages' => $villages])
            <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                <button type="submit" class="mis-btn-primary">Update application</button>
                <a href="{{ route('applications.show', $application) }}" class="mis-btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</x-mis-layout>

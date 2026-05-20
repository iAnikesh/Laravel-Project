<x-mis-layout>
    <x-slot name="header">New housing application</x-slot>
    <x-slot name="subheader">Submit a new application under an active rural housing scheme</x-slot>

    <form method="POST" action="{{ route('applications.store') }}" class="mis-card mx-auto max-w-3xl">
        <div class="mis-card-body">
            @csrf
            @include('mis.applications._form', ['schemes' => $schemes, 'villages' => $villages])
            <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                <button type="submit" class="mis-btn-primary">Save draft</button>
                <a href="{{ route('applications.index') }}" class="mis-btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</x-mis-layout>

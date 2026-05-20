<x-mis-layout>
    <x-slot name="header">Notifications</x-slot>
    <x-slot name="subheader">In-app alerts and status updates</x-slot>

    @if (auth()->user()->unreadNotifications->count())
        <form method="POST" action="{{ route('notifications.read-all') }}" class="mb-4">@csrf
            <button type="submit" class="text-sm font-medium text-emerald-600 hover:underline">Mark all as read</button>
        </form>
    @endif

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <div @class(['rounded-xl border p-4', $notification->read_at ? 'border-slate-200 bg-white' : 'border-emerald-200 bg-emerald-50'])>
                <p class="font-medium text-slate-900">{{ $notification->data['message'] ?? 'Application update' }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                @if (! $notification->read_at)
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="mt-2">@csrf @method('PATCH')
                        <button type="submit" class="text-xs font-medium text-emerald-700 hover:underline">Mark read</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-center text-slate-500 py-10">No notifications yet.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $notifications->links() }}</div>
</x-mis-layout>

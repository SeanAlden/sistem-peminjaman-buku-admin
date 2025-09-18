@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="mb-4 text-xl font-bold">All Notifications</h2>

    @foreach($notifications as $notif)
        <div class="flex items-center justify-between py-2 border-b">
            <div>
                <p class="font-semibold">{{ $notif->title }}</p>
                <p class="text-sm text-gray-600">{{ $notif->message }}</p>
                <small class="text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
            @if(!$notif->is_read)
                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 text-xs text-white bg-green-600 rounded hover:bg-green-700">
                        Read
                    </button>
                </form>
            @endif
        </div>
    @endforeach

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection

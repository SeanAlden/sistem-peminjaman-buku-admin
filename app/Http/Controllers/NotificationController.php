<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // public function index()
    // {
    //     $notifications = Notification::where('user_id', auth()->id())
    //         ->latest()
    //         ->paginate(10);

    //     return view('notification', compact('notifications'));
    // }

    public function index()
    {
        $user = auth()->user();

        if ($user->usertype === 'admin') {
            // Admin lihat semua notifikasi
            $notifications = Notification::latest()->paginate(10);
        } else {
            // User biasa lihat notifikasi miliknya saja
            $notifications = Notification::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('notification', compact('notifications'));
    }

    // public function markAsRead($id)
    // {
    //     $notification = Notification::where('id', $id)
    //         ->where('user_id', auth()->id())
    //         ->firstOrFail();

    //     $notification->update(['is_read' => true]);

    //     return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    // }

    public function markAsRead($id)
    {
        $user = auth()->user();

        if ($user->usertype === 'admin') {
            $notification = Notification::findOrFail($id);
        } else {
            $notification = Notification::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    // public function fetchLatest()
    // {
    //     $notifications = Notification::where('user_id', auth()->id())
    //         ->latest()
    //         ->take(5)
    //         ->get();

    //     $count = Notification::where('user_id', auth()->id())
    //         ->where('is_read', false)
    //         ->count();

    //     return response()->json([
    //         'notifications' => $notifications,
    //         'count' => $count,
    //     ]);
    // }

    public function fetchLatest()
    {
        $user = auth()->user();

        if ($user->usertype === 'admin') {
            $notifications = Notification::latest()->take(5)->get();
            $count = Notification::where('is_read', false)->count();
        } else {
            $notifications = Notification::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
            $count = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'notifications' => $notifications,
            'count' => $count,
        ]);
    }
}

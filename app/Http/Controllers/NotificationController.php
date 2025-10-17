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

    public function index(Request $request)
    {
        // $user = auth()->user();

        // if ($user->usertype === 'admin') {
        //     // Admin lihat semua notifikasi
        //     $notifications = Notification::latest()->paginate(10);
        // } else {
        //     // User biasa lihat notifikasi miliknya saja
        //     $notifications = Notification::where('user_id', $user->id)
        //         ->latest()
        //         ->paginate(10);
        // }

        // return view('notification', compact('notifications'));

        $search = $request->input('search', '');

        $perPage = (int) $request->input('per_page', 5);

        $query = Notification::latest();

        // $view = $request->input('view', 'card'); // default ke card

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $notifications = $query->paginate($perPage)->appends($request->except('page'));

        return view('notification', compact('notifications', 'search', 'perPage'));
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

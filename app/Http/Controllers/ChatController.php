<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(User $user)
    {
        return view('chat', compact('user'));
    }

    public function getMessages(User $user)
    {
        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    // public function sendMessage(Request $request, $userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $message = $request->input('message');

    //     broadcast(new MessageSent($user, [
    //         'from' => auth()->user()->name,
    //         'body' => $message
    //     ]))->toOthers();

    //     return response()->json(['status' => 'Message Sent!']);
    // }

    public function sendMessage(Request $request, $userId)
    {
        $request->validate(['message' => 'required|string']);
        $user = User::findOrFail($userId);
        $text = $request->input('message');

        // 1) Simpan pesan ke DB
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $text,
        ]);

        // 2) Siapkan payload yang dikirim lewat Pusher
        $payload = [
            'id' => $message->id,
            'from_id' => Auth::id(),
            'from' => Auth::user()->name,
            'to_id' => $user->id,
            'body' => $text,
            // 'created_at' => $message->created_at->toDateTimeString(),
            'created_at' => $message->created_at->DateTime.now().toUtc().toIso8601String(),
        ];

        // 3) Broadcast ke channel penerima
        broadcast(new MessageSent($user, $payload))->toOthers();

        // 4) Kembalikan response berisi pesan yang tersimpan
        return response()->json(['status' => 'Message Sent!', 'message' => $payload]);
    }
}


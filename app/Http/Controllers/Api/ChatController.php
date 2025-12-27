<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // public function __construct()
    // {
    //     // gunakan sanctum atau guard api sesuai project Anda
    //     $this->middleware('auth:sanctum');
    // }

    /**
     * Ambil riwayat pesan antara authenticated user dan $otherUserId
     */
    public function getMessages($otherUserId)
    {
        $other = User::findOrFail($otherUserId);

        $messages = Message::where(function ($q) use ($other) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $other->id);
        })->orWhere(function ($q) use ($other) {
            $q->where('sender_id', $other->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        // normalisasi supaya client mudah memetakan
        $payload = $messages->map(function ($m) {
            return [
                'id' => $m->id,
                'from_id' => $m->sender_id,
                'to_id' => $m->receiver_id,
                'body' => $m->message,
                'created_at' => $m->created_at ? $m->created_at->toDateTimeString() : null,
                'sender' => [
                    'id' => $m->sender_id,
                    'name' => $m->sender ? $m->sender->name : null,
                ],
            ];
        });

        return response()->json(['success' => true, 'data' => $payload]);
    }

    /**
     * Simpan pesan dari authenticated user -> $otherUserId, broadcast ke penerima
     */
    public function sendMessage(Request $request, $otherUserId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $other = User::findOrFail($otherUserId);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $other->id,
            'message' => $request->input('message'),
        ]);

        $payload = [
            'id' => $message->id,
            'from_id' => Auth::id(),
            'from' => Auth::user()->name,
            'to_id' => $other->id,
            'body' => $message->message,
            // 'created_at' => $message->created_at->toDateTimeString(),
            'created_at' => $message->created_at->DateTime.now(),
        ];

        // broadcast ke channel penerima (sesuai Event MessageSent::broadcastOn)
        broadcast(new MessageSent($other, $payload))->toOthers();

        return response()->json(['success' => true, 'message' => $payload]);
    }
}
    
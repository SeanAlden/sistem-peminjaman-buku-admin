<?php

// namespace App\Events;

// use App\Models\User;
// use Illuminate\Broadcasting\Channel;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

// // class MessageSent implements ShouldBroadcast
// // {
// //     use Dispatchable, InteractsWithSockets, SerializesModels;

// //     public $user;
// //     public $message;

// //     public function __construct(User $user, $message)
// //     {
// //         $this->user = $user;
// //         $this->message = $message;
// //     }

// //     // Channel untuk tiap user
// //     public function broadcastOn()
// //     {
// //         return new Channel('chat.' . $this->user->id);
// //     }

// //     public function broadcastAs()
// //     {
// //         return 'message.sent';
// //     }
// // }

// class MessageSent implements ShouldBroadcastNow
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public $user;    // penerima (User)
//     public $message; // array payload

//     public function __construct(User $user, $message)
//     {
//         $this->user = $user;
//         $this->message = $message;
//     }

//     public function broadcastOn()
//     {
//         return new Channel('chat.' . $this->user->id);
//     }

//     public function broadcastAs()
//     {
//         return 'message.sent';
//     }

//     // kirim payload khusus
//     public function broadcastWith()
//     {
//         return [
//             'message' => $this->message
//         ];
//     }
// }

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;  // Ubah menjadi $userId (bukan object User)
    public $message;

    // Hapus type hint 'User' agar bisa menerima angka/integer dari Controller
    public function __construct($userId, $message)
    {
        $this->userId = $userId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Langsung gunakan $this->userId
        return new Channel('chat.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}

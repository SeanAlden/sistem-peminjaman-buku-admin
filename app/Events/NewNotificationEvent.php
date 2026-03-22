<?php

// namespace App\Events;

// use App\Models\Notification;
// use Illuminate\Broadcasting\Channel;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// class NewNotificationEvent implements ShouldBroadcast
// {
//     use SerializesModels;

//     public $notification;

//     public function __construct(Notification $notification)
//     {
//         $this->notification = $notification;
//     }

//     public function broadcastOn()
//     {
//         return new Channel('notifications');
//     }

//     public function broadcastAs()
//     {
//         return 'new-notification';
//     }
// }

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
// UBAH 1: Gunakan ShouldBroadcastNow
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

// UBAH 2: Implement ShouldBroadcastNow
class NewNotificationEvent implements ShouldBroadcastNow
{
    // UBAH 3: Tambahkan Dispatchable dan InteractsWithSockets (Standar Laravel Event)
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    public function broadcastAs()
    {
        return 'new-notification';
    }
}

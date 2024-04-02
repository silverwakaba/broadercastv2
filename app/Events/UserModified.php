<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserModified implements ShouldBroadcastNow{
    use Dispatchable, InteractsWithSockets;

    public $user;

    public function __construct($user){
        $this->user = $user;
    }

    public function broadcastOn() : array{
        return [
            new Channel('usersChannel'),
        ];
    }

    public function broadcastAs() : string{
        return 'UserModified';
    }
}

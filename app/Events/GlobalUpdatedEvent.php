<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GlobalUpdatedEvent implements ShouldBroadcastNow{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datas;

    public function __construct($datas){
        $this->datas = $datas;
    }

    public function broadcastOn() : array{
        return [
            new Channel('globalChannel'),
        ];
    }

    public function broadcastAs() : string{
        return 'globalUpdated';
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TokenFcmEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;

    public $token;

    public $device_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $device_id, $token)
    {
        $this->user_id = $user_id;
        $this->token = $token;
        $this->device_id = $device_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

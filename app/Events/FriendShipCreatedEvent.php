<?php

namespace App\Events;

use App\Models\Users\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendShipCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public User $user1,$user2;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user1,User $user2)
    {
        $this->user1 = $user1;
        $this->user2 = $user2;
    }

}

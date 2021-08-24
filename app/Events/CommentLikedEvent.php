<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentLikedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $user,$comment,$liker,$message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$comment,$liker)
    {
        $this->user=$user;
        $this->comment=$comment;
        $this->liker=$liker;
        $this->message="$liker->name ".'liked your comment';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user'.$this->user->id);
    }
}

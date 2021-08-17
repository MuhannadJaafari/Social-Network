<?php

namespace App\Listeners;

use App\Events\FriendShipCreatedEvent;
use App\Models\Conversation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
class CreateConversationListener
{
    /**
     * Handle the event.
     *
     * @param  FriendShipCreatedEvent  $event
     * @return void
     */
    public function handle(FriendShipCreatedEvent $event)
    {
        Conversation::create([
            'user1_id'=>$event->user1->id,
            'user2_id'=>$event->user2->id,
        ]);
    }
}

<?php

namespace App\Listeners;

use App\Events\ReplyDeletedEvent;
use App\Models\Comment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReplyDeletedListener
{

    /**
     * Handle the event.
     *
     * @param  ReplyDeletedEvent  $event
     * @return void
     */
    public function handle(ReplyDeletedEvent $event)
    {
        $reply = $event->reply;
        $reply = Comment::find($reply->id);
        $reply->delete();
    }
}

<?php

namespace App\Listeners;

use App\Events\CommentLikedEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentLikedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentLikedEvent  $event
     * @return void
     */
    public function handle(CommentLikedEvent $event)
    {
        $notification=new Notification();
        $notification->message=$event->message;
        $event->user->notifications()->save($notification);
    }
}

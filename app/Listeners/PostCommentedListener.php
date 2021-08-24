<?php

namespace App\Listeners;

use App\Events\PostCommentedEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostCommentedListener
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
     * @param  PostCommentedEvent  $event
     * @return void
     */
    public function handle(PostCommentedEvent $event)
    {
        $notification=new Notification();
        $notification->message=$event->message;
        $event->user->notifications()->save($notification);
    }
}

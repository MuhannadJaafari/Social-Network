<?php

namespace App\Listeners;

use App\Events\PostLikedEvent;
use App\Http\Requests\UserAccountCreatingRequest;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostLikedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(PostLikedEvent $event)
    {
     $notification=new  Notification();
     $notification->message=$event->message;
     $event->user->notifications()->save($notification);
    }
}

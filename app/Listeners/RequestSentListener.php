<?php

namespace App\Listeners;

use App\Events\RequestSentEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mockery\Matcher\Not;

class RequestSentListener
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
     * @param  RequestSentEvent  $event
     * @return void
     */
    public function handle(RequestSentEvent $event)
    {
        $notification=new Notification();
        $notification->message=$event->message;
        $event->user->notifications()->save($notification);
    }
}

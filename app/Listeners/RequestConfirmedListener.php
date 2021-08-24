<?php

namespace App\Listeners;

use App\Events\RequestConfirmedEvent;
use App\Models\Notification;


class RequestConfirmedListener
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
     * @param  RequestConfirmedEvent  $event
     * @return void
     */
    public function handle(RequestConfirmedEvent $event)
    {
        $notification=new Notification();
        $notification->message=$event->message;
        $event->user->notifications()->save($notification);
    }
}

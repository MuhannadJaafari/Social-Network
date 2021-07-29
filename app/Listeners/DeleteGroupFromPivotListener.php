<?php

namespace App\Listeners;

use App\Events\GroupDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteGroupFromPivotListener
{

    /**
     * Handle the event.
     *
     * @param GroupDeleteEvent $event
     * @return void
     */
    public function handle(GroupDeleteEvent $event)
    {
        $event->group->users()->detach();
    }
}

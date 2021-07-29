<?php

namespace App\Listeners;

use App\Events\PageDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeletePageFromPivotListener
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
     * @param  PageDeletedEvent  $event
     * @return void
     */
    public function handle(PageDeletedEvent $event)
    {

        $event->page->users()->detach();
     //   $event->page->users->delete();
    }
}

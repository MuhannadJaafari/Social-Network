<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostDeleteRelations
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
     * @param PostDeletedEvent $event
     * @return void
     */
    public function handle(PostDeletedEvent $event)
    {
        $post = $event->post;
        foreach ($post->photos()->get() as $photo) {
            $photo->delete();
        }
        foreach ($post->videos()->get() as $video) {
            $video->delete();
        }
        foreach($post->comments as $comment){
            $comment->delete();
        }
        $post->hashtags()->detach();
    }
}

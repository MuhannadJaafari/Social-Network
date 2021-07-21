<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;

class PostDeleteRelations
{

    /**
     * Handle the event.
     *
     * @param PostDeletedEvent $event
     * @return void
     */
    public function handle(PostDeletedEvent $event)
    {
        $post = $event->post;
        foreach ($post->likes()->get() as $like) {
            $like->delete();
        }
        foreach ($post->photos()->get() as $photo) {
            $photo->delete();
        }
        foreach ($post->videos()->get() as $video) {
            $video->delete();
        }
        foreach ($post->comments()->get() as $comment) {
            $comment->delete();
        }
        $post->hashtags()->detach();
    }
}

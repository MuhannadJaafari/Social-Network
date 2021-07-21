<?php

namespace App\Listeners;

use App\Events\CommentDeletedEvent;


class CommentDeleteRelations
{
    /**
     * Handle the event.
     *
     * @param CommentDeletedEvent $event
     * @return void
     */
    public function handle(CommentDeletedEvent $event)
    {
        $comment = $event->comment;
        foreach ($comment->likes()->get() as $like) {
            $like->delete();
        }
        foreach ($comment->photo()->get() as $photo) {
            $photo->delete();
        }
        foreach ($comment->video()->get() as $video) {
            $video->delete();
        }
        foreach ($comment->replies()->get() as $reply) {
            $reply->delete();
        }
        $comment->hashtags()->detach();
    }
}

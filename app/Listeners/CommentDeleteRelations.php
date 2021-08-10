<?php

namespace App\Listeners;

use App\Events\CommentDeletedEvent;
use App\Models\Comment;


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
//        $comment->likes()-
//        foreach ($comment->likes()->get() as $like) {
//            $like->delete();
//        }
//        foreach ($comment->photo()->get() as $photo) {
//            $photo->delete();
//        }
//        foreach ($comment->video()->get() as $video) {
//            $video->delete();
//        }
//        foreach ($comment->replies()->get() as $reply) {
//            $reply->delete();
//        }
//        foreach ($comment->replies as $reply) {
//            $rComment = Comment::find($reply->pivot->reply_id);
//            $rComment->replies()->detach();
//            $rComment->delete();
//        }
//        $comment->replies()->detach();
//        $comment->hashtags()->detach();
    }
}

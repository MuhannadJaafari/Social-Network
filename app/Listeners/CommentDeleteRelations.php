<?php

namespace App\Listeners;

use App\Events\CommentDeletedEvent;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;


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
        if ($comment->reply === 1) {
            $reply = Reply::where('reply_id', '=', $comment->id);
            $reply->delete();
        } else {
            $comment->replies()->detach();
        }
        $comment->hashtags()->detach();
    }
}

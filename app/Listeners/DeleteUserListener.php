<?php

namespace App\Listeners;

use App\Events\UserDeletedEvent;
use App\Models\Group;
use App\Models\Page;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteUserListener
{


    /**
     * Handle the event.
     *
     * @param UserDeletedEvent $event
     * @return void
     */
    public function handle(UserDeletedEvent $event)
    {
        $user = $event->user;
        foreach ($user->posts as $post) {
            $post->delete();
        }
        $user->address->delete();
        $user->username->delete();

        foreach ($user->conversations as $conversation) {
            $conversation->delete();
        }

        foreach ($user->relationUser('user1_id', 'user2_id')->get() as $relation) {
            $relation->pivot->delete();
        }
        foreach ($user->relationUser('user2_id', 'user1_id')->get() as $relation) {
            $relation->pivot->delete();
        }

        foreach ($user->groups as $group) {
            $group->pivot->delete();
        }
        foreach (Group::where('creator_id', '=', $user->id)->get() as $group) {
            $group->delete();
        }
        foreach ($user->pages as $page) {
            $page->pivot->delete();
        }
        foreach (Page::where('creator_id', '=', $user->id)->get() as $page) {
            $page->delete();
        }
    }
}

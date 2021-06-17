<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Video;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function isOwner(User $user,Video $video)
    {
        $post=Post::find($video->videoable_id);
        return $user->id===$post->postable_id;
    }
}

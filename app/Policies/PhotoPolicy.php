<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
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
    public function isOwner(User $user,Photo $photo)
    {
        $post=Post::find($photo->photoable_id);
        return $user->id===$post->postable_id;
    }
}

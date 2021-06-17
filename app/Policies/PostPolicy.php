<?php

namespace App\Policies;

use App\Models\Users\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;


class PostPolicy
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
    public function isOwner(User $user,Post $post): bool
    {
        return $user->id === $post->postable_id;
    }

}

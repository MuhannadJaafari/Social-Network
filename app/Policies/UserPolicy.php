<?php

namespace App\Policies;

use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class
UserPolicy
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

    public function isOwner(User $changing_user, User $changed_user): bool
    {
        return $changed_user === $changing_user;
    }

    public function canViewUser(User $currentUser, User $targetUser)
    {
        $relation = $currentUser->relationUser('user2_id', 'user1_id')->where('user1_id', '=', $targetUser->id)->first();
        if (!$relation) {
            $relation = $currentUser->relationUser('user1_id', 'user2_id')->where('user2_id', '=', $targetUser->id)->first();
        }
        if (!$relation)
            return true;
        $relation = $relation->pivot;
        return $relation->relation != 'blocked';
    }

    public function canUnblock(User $currentUser, User $targetUser)
    {
        $relation = $currentUser->relationUser('user2_id', 'user1_id')->where('user1_id', '=', $targetUser->id)->first();
        if (!$relation) {
            $relation = $currentUser->relationUser('user1_id', 'user2_id')->where('user2_id', '=', $targetUser->id)->first();
        }
        if (!$relation)
            return false;
        $relation = $relation->pivot;
        return $relation->blocker === $currentUser->id;
    }

    public function canBlock(User $currentUser, User $targetUser)
    {
        return $currentUser->id !== $targetUser->id;
    }
}

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
        $relation = $currentUser->relations()
            ->where('user1_id', '=', $targetUser->id)
            ->orWhere('user2_id', '=', $targetUser->id)
            ->first();
        if (!$relation)
            return true;
        $relation = $relation->pivot;
        return $relation->relation != 'blocked';
    }
    public function canUnblock(User $currentUser, User $targetUser){
        $relation = $currentUser->relations()
            ->where('user1_id', '=', $targetUser->id)
            ->orWhere('user2_id', '=', $targetUser->id)
            ->withPivot('blocker')
            ->first()->pivot;
        return $relation->blocker === $currentUser->id;
    }
}

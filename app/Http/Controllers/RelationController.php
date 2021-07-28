<?php

namespace App\Http\Controllers;

use App\Models\RelationUser;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RelationController extends Controller
{
    public function getCurrentRelation(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $this->getRelationBetweenTwoUsers($user->id, $request->id);
        if (!$relation) {
            $response = [
                'relation' => 'no relation'
            ];
        } else {
            $response = [
                'relation' => $relation->pivot->relation
            ];
        }
        return response()->json([
            $response
        ]);
    }

    public function add(Request $request)
    {
        //todo make request protection for id of user incoming
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user2 = User::find($request->id);
        if ($this->getRelationBetweenTwoUsers($user->id, $request->id)) {
            return;
        }
        $user->relationUser('user1_id', 'user2_id')->save($user2);
    }

    public function accept(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user->relationUser('user2_id', 'user1_id')->where('user1_id', '=', $request->id)->first();
        if (!$relation) {
            return response('No Relation Found between ' . $user->id . ' and ' . $request->id, 500);
        }
        $relation = $relation->pivot;
        $relation->relation = 'friends';
        $relation->save();
    }

    public function block(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        if (!Gate::allows('can-block-user', User::find($request->id))) {
            return response('User can\'t block himself', 403);
        }
        $relation = $user->relationUser('user2_id', 'user1_id')->where('user1_id', $request->id)->first();
        if (!$relation) {
            $relation = $user->relationUser('user1_id', 'user2_id')->where('user2_id', $request->id)->first();
        }
        if (!$relation) {
            $this->add($request);
        }
        $relation = $user->relationUser('user1_id', 'user2_id')->where('user2_id', '=', $request->id)->first()->pivot;
        if ($relation->blocker !== null) {
            return response('already blocked');
        }
        $relation->relation = 'blocked';
        $relation->blocker = $user->id;
        $relation->save();
    }

    public function unblock(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        if (!Gate::allows('can-unblock-user', User::find($request->id))) {
            return response('user blocked you or there is no block relation', 403);
        }
        $relation = $user->relationUser('user2_id', 'user1_id')->where('user1_id', $request->id)->first();
        if (!$relation) {
            $relation = $user->relationUser('user1_id', 'user2_id')->where('user2_id', $request->id)->first();
        }
        $relation->pivot->delete();
    }

    public function delete(Request $request)
    {

        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user->relationUser('user2_id', 'user1_id')->where('user1_id', $request->id)->first();
        if (!$relation) {
            $relation = $user->relationUser('user1_id', 'user2_id')->where('user2_id', $request->id)->first();
        }
        if ($relation)
            $relation->pivot->delete();
    }

    public function getFriendsRequests()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        return $user->relationUser('user2_id', 'user1_id')
            ->where('relation', '=', 'requested')
            ->get()
            ->makeHidden(['pivot', 'birth_date']);
    }

    private function getRelationBetweenTwoUsers($user1_id, $user2_id)
    {
        $relation = RelationUser::where('user1_id', '=', $user1_id)->where('user2_id', '=', $user2_id)
            ->orWhere(function ($query) use ($user1_id, $user2_id) {
                $query->where('user2_id', '=', $user1_id)
                    ->where('user1_id', '=', $user2_id);
            })->first();
        if (!$relation) {
            return false;
        }
        return $relation;
    }

    public function getFriends()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation1 = $user->relationUser('user2_id', 'user1_id');
        $relation2 = $user->relationUser('user1_id', 'user2_id');
        return $this->helper->mergeObjects($relation1, $relation2);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\RelationUser;
use App\Models\Users\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->body) {
            $users = User::where('name', 'like', '%' . $request->body . '%')
                ->orderBy('name')->get();
            $collection = [];
            foreach ($users as $user) {
                if ($this->canSee($user)) {
                    $user->profilePic = collect($user->photo()->where('current', '=', '1')->first())->get('url');
                    array_push($collection, $user);
                }
            }
            return $collection;
        }
    }

    private function canSee($user): bool
    {
        $relation = RelationUser::where('user1_id', '=', auth()->user()->id)->where('user2_id', '=', $user->id)
            ->orWhere(function ($query) use ($user) {
                $query->where('user1_id', '=', $user->id)
                    ->where('user2_id', '=', auth()->user()->id);
            })->first();
        if (!$relation || $relation->relation !== 'blocked') {
            return true;
        }
        return false;
    }
}

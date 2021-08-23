<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Photo;
use App\Models\RelationUser;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    /**
     * Display the specified resource.
     *
     *
     */
    public function show(Request $request)
    {

        $user = User::findOrFail($request->user_id);
        if (!Gate::allows('can-view-user', $user)) {
            return response('Unauthorized', 403);
        }

        $address = $user->address()->first();
        $profilePic = $user->photo()->where('photo_type', '=', 'profile')->where('current', '=', '1')->first();
        $coverPic = $user->photo()->where('photo_type', '=', 'cover')->where('current', '=', '1')->first();
        $user_page = [
            'id' => $user->id,
            'name' => $user->name,
            'profile_pic' => ($profilePic === null ? 'null' : $profilePic->url),
            'cover_pic' => ($coverPic === null ? 'null' : $coverPic->url),
            'town' => $address === null ? 'null' : $address->town,
            'city' => $address === null ? 'null' : $address->city,
        ];
        $friendship = 'null';
        $sender_id = 'null';
        if ($request->user_id !== auth()->user()->id) {
            $user1_id = $request->user_id;
            $user2_id = auth()->user()->id;
            $friendship = RelationUser::where('user1_id', '=', $user1_id)->where('user2_id', '=', $user2_id)
                ->orWhere(function ($query) use ($user1_id, $user2_id) {
                    $query->where('user1_id', '=', $user2_id)
                        ->where('user2_id', '=', $user1_id);
                })->first();

        }
        if (!$friendship) $friendship = ['relation' => null];
        else
            $friendship->senderId = $friendship->user1_id;
        return response()->json([collect($user_page)->merge($friendship)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //name/email/password/profilePic/coverPic/username/birth_date/address
        $user = User::find(auth()->user()->getAuthIdentifier());
        if ($user->email && $user->email != $request->email) {
            $request->validate(['email' => 'unique:App\Models\Users\User,email']);
        }
        if ($user->username != $request->username) {
            $request->validate(['email' => 'unique:usernames,name']);
        }
//        $user->update([$request->all()]);
//        Address::updateOrCreate(
//            [   ],[]
//        );

        $user->username()->update([
            $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->delete();
    }

    public function getPosts($id)
    {
        $user = User::find($id);
        return response()->json($user->post());
    }

    public function newsFeed()
    {
        $id = auth()->user()->getAuthIdentifier();
        $user = User::find($id);
        return response()->json([
            $user->posts
        ]);
    }


}

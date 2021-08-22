<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Photo;
use App\Models\RelationUser;
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

        $user = User::find($request->user_id);
        if (!Gate::allows('can-view-user', $user)) {
            return response('Unauthorized', 403);
        }

        $address = $user->address()->first();

        $user_page = [
            'id' => $user->id,
            'name' => $user->name,
//            'profile_pic'=>$user->photo()->where('photo_type','=','profile')->where('current','=','1')->first()->url,
//            'cover_pic'=>$user->photo()->where('photo_type','=','cover')->where('current','=','1')->first()->url,
            'town' => $address->town,
            'city' => $address->city,
        ];
        $friendshipStatus = null;
         if($request->user_id !==auth()->user()->id){
             $user1_id = $request->user_id;
             $user2_id = auth()->user()->id;
             $friendshipStatus = RelationUser::where('user1_id', '=', $user1_id)->where('user2_id', '=', $user2_id)
                 ->orWhere(function ($query) use ($user1_id, $user2_id) {
                     $query->where('user2_id', '=', $user1_id)
                         ->where('user1_id', '=', $user2_id);
                 })->first();
             if(!$friendshipStatus){
                 $friendshipStatus = $user->relationUser(auth()->user()->id,$request->user_id)->first();
                 if(!$friendshipStatus){
                     $friendshipStatus = null;
                 }
             }

         }

            return response()->json([collect($user_page)->merge($friendshipStatus)]);
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
        if ($user->email != $request->email) {
            $request->validate(['email' => 'unique:App\Models\Users\User,email']);
        }
        if ($user->username != $request->username) {
            $request->validate(['email' => 'unique:usernames,name']);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'birth_date' => $request->birth_date
        ]);
        $this->storeProfilePic($user, $request->profile_pic);
        $this->storeCoverPic($user, $request->cover_pic);
        $user->address()->update([
            'city' => $request->city,
            'town' => $request->town,
        ]);

        $user->username()->update([
            'name' => $request->username,
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

    private function storeProfilePic($user, $photo)
    {
        if (!$photo) {
            return;
        }
        $oldPhoto = Photo::where('photo_type', '=', 'profile')->where('current', '=', '1')->first();
        if ($oldPhoto) {
            $oldPhoto->current = 0;
            $oldPhoto->save();
        }
        $newPhoto = new Photo();
        $path = $photo->store(
            '', 'public'
        );
        $newPhoto->url = asset('/') . '/' . $path;
        $newPhoto->photo_type = 'profile';
        $newPhoto->current = 1;
        $user->photo()->save($newPhoto);
    }

    private function storeCoverPic($user, $photo)
    {
        if (!$photo) {
            return;
        }
        $oldPhoto = Photo::where('photo_type', '=', 'cover')->where('current', '=', '1')->first();
        if ($oldPhoto) {
            $oldPhoto->current = 0;
            $oldPhoto->save();
        }
        $newPhoto = new Photo();
        $path = $photo->store(
            'coverPic', 'public'
        );
        $newPhoto->url = asset('storage') . '/' . $path;
        $newPhoto->photo_type = 'cover';
        $newPhoto->current = 1;
        $user->photo()->save($newPhoto);
    }

    public function updateUserPhotos(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $this->storeProfilePic($user, $request->profilePhoto);
        $this->storeCoverPic($user, $request->coverPhoto);
    }

}

<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\RelationUser;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{


    /**
     * Display the specified resource.
     *
     *
     */
    public function show(User $user)
    {


        if (!Gate::allows('can-view-user', $user)) {
            return response('Unauthorized', 403);
        }

        $address = $user->address()->first();

        $user_page = [
            'id' => $user->id,
            'name' => $user->name,
            //profile pic
            //cover pic
            'town' => $address->town,
            'city' => $address->city,
        ];

        return response()->json([$user_page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('isOwner', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

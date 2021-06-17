<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=User::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(User $user)
    {
        $address = $user->address()->first();
        $user_page = [
            'id'=>$user->id,
            'name'=>$user->name,
            //profile pic
            //cover pic
            'town'=>$address->town,
            'city'=>$address->city,
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
        $user=User::find($id);
        $this->authorize('isOwner',$user);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        $this->authorize('isOwner',$user);
        $user->delete();
        return response()->json(['done']);
    }

    public function getPosts($id)
    {
        $user = User::find($id);
        return response()->json($user->post());
    }

    public function getFriends($id)
    {
        $user = User::find($id);
        return response()->json($user->relations());
    }

}

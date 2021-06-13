<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
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
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
         $user= User::find($id);
         return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
       $user=User::find($id);
       $user->delete();
    }
    public function getProfilePic($id)
    {
      //  $profile_pic= Photo::where('imageable_id',id)->where('imageable_type','profile_pic');
        // if($profile_pic)return $profile_pic;
    }
    public function getPosts($id)
    {
        $user =User::find($id);
        return response()->json($user->post());


    }
    public function getFriends($id)
    {
        $user=User::find($id);
       return response()->json($user->relations());
    }
    public function getPhotos($id)
    {
        $user=User::find($id);
        return response()->json(['photo_url'=>$user->posts()->photos()->url()]);
    }
}

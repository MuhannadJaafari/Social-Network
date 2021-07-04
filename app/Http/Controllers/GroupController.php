<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Role;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        $group =new Group();
        $group->name=$request->name;
        $user=User::find(auth()->user()->getAuthIdentifier());
        $user->groups()->save($group);
        $username=new Username();
        $username->name=$request->username;
        $group->username()->save($username);
        $photo=new Photo();
        $photo->url=$request->photo_url;
        $photo->photo_type='profile';
        $group->photo()->save($photo);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
    public function addRole(Request $request){
        $group = Group::find($request->group_id);
        $role= new Role();
        $role->user_id=$request->user_id;
        $group->roles()->save($role);
    }
    public function addGroupPost(Request $request){
        $group=Group::find($request->group_id);
        $post= new Post();
        $post->text_body=$request->text_body;
        $group->posts()->save($post);
    }
}

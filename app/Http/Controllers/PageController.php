<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Page;
use App\Models\Photo;

use App\Models\Role;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class PageController extends Controller
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
        $page=new Page();
        $page->name=$request->name;

        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->pages()->save($page);
        $username=new Username();
        $username->name=$request->username;
        $page->username()->save($username);
        $photo=new Photo();
        $photo->url=$request->photo_url;
        $photo->photo_type='profile';
        $page->photos()->save($photo);
        $cover =new Photo();
        $cover->url=$request->cover_url;
        $cover->photo_type='cover';
        $page->photos()->save($cover);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
    public function addRole(Request $request)
    {
        $role=new Role();
        $page = Page::find($request->page_id);
        $role->user_id=$request->user_id;
        $page->roles()->save($role);
    }
}

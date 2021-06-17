<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Text;
use App\Models\Users\User;
use App\Models\Video;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class PostController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=auth()->user();
        $post=new Post;
        $post->text_body=$request->text_body;
        $user->posts()->save($post);
        /*$request=collect($request);
        $post_info = $this->helper->filter($request,['user_id,postable_id,postable_type,text,photo_url,video_url']);
        $post=Post::create($post_info['user_id,postable_id,postable_type,text']);*/

        /*if($post_info['photo_url'])
        {
          //TODO
        }
        if($post_info['vider_url'])
        {
            //TODO
        }*/

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {   $post=Post::find($id);
        return response()->json(
            ['post_text'=>$post->text(),
            'post_images_url'=>[$post->photos()->url()],
            'post_videos_url'=>[$post->videos()->url()]
            ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param Post $edited_post
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Post $edited_post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(Request $request)
    {
        $post=Post::find($request->id);
        $this->authorize('isOwner',$post);
        $post->text_body=$request->text_body;
        $post->update();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {

        $post=Post::find($request->id);
        $this->authorize('isOwner',$post);
        $post->delete();
        return response()->json(['done']);
    }
    public function getLikes($id)
    {
        $post=Post::find($id);
        return response()->json($post->likes());
    }
    public function getComments($id)
    {
        $post=Post::find($id);
        return response()->json([
          'comment_text'=>$post->comments()->text(),
          'comment_image_url'=>$post->comments()->photo()->url(),
          'comment_video_url'=>$post->comments()->video()->url()
        ]);

    }
}

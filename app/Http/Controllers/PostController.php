<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Text;
use App\Models\Video;
use http\Env\Response;
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
    public function destroy($id)
    {
        $post=Post::find($id);
        $post->delete();
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

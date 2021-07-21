<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Users\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $like = new Like();
        $like->user_id = auth()->user()->getAuthIdentifier();
        $post->likes()->save($like);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->post_id);
        $like = $post->likes()->where('user_id','=',auth()->user()->getAuthIdentifier())->first();
        $like->delete();
    }

    public function getLikes(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        return $post->likes()->simplePaginate(10);
    }
}

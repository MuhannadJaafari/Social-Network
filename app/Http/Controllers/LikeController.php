<?php

namespace App\Http\Controllers;

use App\Events\CommentLikedEvent;
use App\Events\PostLikedEvent;
use App\Models\Comment;
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
        if ($request->post_id) {
            $liked = Post::findOrFail($request->post_id);
        } else if ($request->comment_id) {
            $liked = Comment::findOrFail($request->comment_id);
        }
        $like = new Like();
        $like->user_id = auth()->user()->getAuthIdentifier();
        $liked->likes()->save($like);
        if(!User::find($liked->postable_id)==User::find(auth()->user()->id)){
        if($request->post_id){
            PostLikedEvent::dispatch(User::find($liked->postable_id),$liked,User::find(auth()->user()->getAuthIdentifier()));
        }
        else if($request->comment_id){
            CommentLikedEvent::dispatch(User::find($liked->user_id),$liked,User::find(auth()->user()->getAuthIdentifier()));
        }}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->post_id) {
            $deleted = Post::find($request->post_id);
        } else if ($request->comment_id) {
            $deleted = Comment::find($request->comment_id);
        }
       $like=$deleted->likes()->where('user_id', '=', auth()->user()->getAuthIdentifier())->first();
        $like->delete();
    }

    public function getLikes(Request $request)
    {
        if ($request->post_id) {
            $liked = Post::findOrFail($request->post_id);
        } else if ($request->comment_id) {
            $liked = Comment::findOrFail($request->comment_id);
        }
        return $liked->likes()->simplePaginate(10);
    }
}

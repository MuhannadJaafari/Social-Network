<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
use App\Models\Video;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $comment = new Comment;
        $post = Post::find($request->post_id);
        $comment->user_id = auth()->user()->getAuthIdentifier();
        $comment->post_id = $request->post_id;
        $comment->text_body = $request->text_body;

        $comment->save();

        if ($request->photo_url) {
            $photo = new Photo();
            $photo->url = $request->photo_url;
            $comment->photo()->save($photo);
        } else if ($request->video_url) {
            $video = new Video();
            $video->url = $request->video_url;
            $comment->video()->save($video);
        }
        return \response()->json(['done']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $comment = Comment::find($id);
        return response()->json([
            'comment_text' => $comment->text(),
            'comment_photo_url' => $comment->photo()->url(),
            'comment_video_url' => $comment->video()->url()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resourcze in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request): JsonResponse
    {
        $comment = Comment::find($request->id);
        $this->authorize('isOwner', $comment);
        $comment->text_body = $request->text_body;
        $comment->update();
        return \response()->json(['done']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request): JsonResponse
    {
        $comment = Comment::find($request->comment_id);
        $this->authorize('isOwner', $comment);
        $comment->delete();
        return response()->json(['done']);
    }

    public function getComments(Request $request)
    {
        //todo know how $comment->photo works
        $post = Post::find($request->id);
        $comments = $post->comments()->simplePaginate(10);
        foreach ($comments as $comment) {
            $comment->photo;
            $comment->video;
        }
        return $comments;
    }

    public function reply(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $user = User::find(auth()->user()->getAuthIdentifier());
        $reply = new Comment();
        $reply->reply = true;
        $reply->text_body = $request->text_body;
        $reply->user_id = $user->id;
        $reply->post_id = $comment->post_id;
        $reply->save();

        $reply->replies()->save($comment);
        if ($request->photo_url) {
            $photo = new Photo();
            $photo->url = $request->photo_url;
            $reply->photo()->save($photo);
        } else if ($request->video_url) {
            $video = new Video();
            $video->url = $request->video_url;
            $reply->video()->save($video);
        }
    }
}

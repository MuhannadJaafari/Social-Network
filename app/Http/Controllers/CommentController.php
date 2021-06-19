<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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
        $comment =new Comment;
        $comment->user_id=auth()->user()->id;
        $comment->post_id=$request->post_id;
        $comment->text_body=$request->text_body;
        $comment->save();
        return \response()->json(['done']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $comment =Comment::find($id);
        return response()->json([
            'comment_text'=>$comment->text(),
            'comment_photo_url'=>$comment->photo()->url(),
            'comment_video_url'=>$comment->video()->url()
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
                $comment =Comment::find($request->id);
                $this->authorize('isOwner',$comment);
                $comment->text_body=$request->text_body;
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
        $comment =Comment::find($request->comment_id);
        $this->authorize('isOwner',$comment);
        $comment->delete();
        return response()->json(['done']);
    }
}

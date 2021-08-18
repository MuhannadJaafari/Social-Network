<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
use App\Models\Video;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $post = Post::find($request->post_id);
        $comment->user_id = auth()->user()->getAuthIdentifier();
        $comment->text_body = $request->text_body;
        $post->comments()->save($comment);
        $this->storePhoto($request, $comment);
        $this->storeVideo($request, $comment);
        $this->storeHashtags($request, $comment);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $comment = Comment::find($request->id);
        return response()->json([
            'comment_text' => $comment->text(),
            'comment_photo_url' => $comment->photo()->url(),
            'comment_video_url' => $comment->video()->url()
        ]);
    }

    /**
     * Update the specified resourcze in storage.
     *
     * @param Request $request
     * @throws AuthorizationException
     */
    public function update(Request $request)
    {
        $this->updateComment($request->comment_id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @throws AuthorizationException
     */
    public function destroy(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $this->authorize('isOwner', $comment);
        $comment->delete();
    }



    public function getComments(Request $request)
    {
        //todo know how $comment->photo works
        $post = Post::findOrFail($request->post_id);
        $comments = $post->comments()->simplePaginate(10);
        foreach ($comments as $comment) {
            $comment->photo;
            $comment->video;
        }
        return $comments;
    }

    public function reply(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $post = Post::findOrFail($request->post_id);
        $user = User::find(auth()->user()->getAuthIdentifier());
        $reply = new Comment();

        $reply->reply = true;
        $reply->text_body = $request->text_body;
        $reply->user_id = $user->id;

        $post->comments()->save($reply);
        $comment->replies()->save($reply);

        $this->storePhoto($request, $reply);
        $this->storeVideo($request, $reply);
        $this->storeHashtags($request, $reply);
    }

    public function updateReply(Request $request)
    {
        $this->updateComment($request->reply_id, $request);
    }

    private function storePhoto(Request $request, Comment $comment)
    {
        if (!$request->photo) {
            return;
        }
        $newPhoto = new Photo();
        $newPhoto->url = $request->photo->store('commentPhoto');
        $comment->photo()->save($newPhoto);
    }

    private function storeVideo(Request $request, Comment $comment)
    {
        if (!$request->video) {
            return;
        }
        $newVideo = new Video();
        $newVideo->url = $request->video->store('commentVideo');
        $comment->video()->save($newVideo);
    }

    private function storeHashtags(Request $request, Comment $comment)
    {
        if (!$request->hashtags) {
            return;
        }
        foreach ($request->hashtags as $hashtag) {
            $newHashtag = Hashtag::where('name', '=', $hashtag)->first();
            if (!$newHashtag) {
                $newHashtag = Hashtag::create(['name' => $hashtag]);
            }
            $comment->hashtags()->save($newHashtag);
        }
    }

    private function updateComment($id, Request $request)
    {
        $comment = Comment::find($id);
        $this->authorize('isOwner', $comment);
        if ($request->text_body) {
            $comment->text_body = $request->text_body;
        }
        if ($request->deleted_photo_id) {
            $photo = Photo::find($request->deleted_photo_id);
            $photo->delete();
        }
        if ($request->deleted_video_id) {
            $video = Video::find($request->deleted_video_id);
            $video->delete();
        }
        $this->storePhoto($request, $comment);
        $this->storeVideo($request, $comment);
        $this->storeHashtags($request, $comment);
        $comment->update();
    }
}

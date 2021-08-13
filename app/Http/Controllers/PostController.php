<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
use App\Models\Video;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $user = User::find(auth()->user()->getAuthIdentifier());
        $post = new Post();
        $post->text_body = $request->text_body;
        $post = $user->posts()->save($post);
        $this->storeHashTags($request, $post);
        $this->storePhotos($request->instance(), $post);
        $this->storeVideos($request->instance(), $post);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $post = Post::find($request->id);
        return response()->json(
            ['post_text' => $post->text(),
                'post_images_url' => [$post->photos()->url()],
                'post_videos_url' => [$post->videos()->url()]
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request)
    {

        $post = Post::find($request->post_id);
        //return $post;
        $this->authorize('isOwner', $post);
        $post->text_body=$request->text_body;
        foreach ($request->deleted_photos as $id){
            $photo=Photo::find($id);
            $photo->delete();
        }
//        foreach ($request->added_photos as $photourl){
//            $photo = new Photo();
//            $photo->url=$photourl;
//            $post->photos()->save($photo);
//        }
        $this->storePhotos($request,$post);
        foreach ($request->deleted_videos as $id){
            $video=Video::find($id);
            $video->delete();
        }
//        foreach ($request->added_videos as $videourl){
//            $video=new Video();
//            $video->url=$videourl;
//            $post->videos()->save($video);
//        }
        $this->storeVideos($request,$post);
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->delete();
    }

    public function getPosts(Request $request, $id = null)
    {
        $id = $id === null ? auth()->user()->getAuthIdentifier() : $id;
        $user = User::find($id);
        $posts = $user->posts()->simplePaginate(3);
        foreach ($posts as $post) {
            $post->photos;
            $post->videos;
            $post->hashtags;
        }
        return $posts;
    }

    public function getTimeline(Request $request)
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $friends = $user->relationUser('user2_id', 'user1_id')->wherePivot('relation', '=', 'friends');
        $friends2 = $user->relationUser('user1_id', 'user2_id')->wherePivot('relation', '=', 'friends');
        $arr = array();
        $collection_of_friends = $this->helper->mergeObjects($friends, $friends2);
        foreach ($collection_of_friends as $friend) {
            foreach ($friend->posts as $post) {
                $post->photos;
                $post->videos;
                array_push($arr, $post);
            }
        }
        return $this->helper->paginate(collect($arr)->sortBy('updated_at'), 3, null, ['path' => $request->fullUrl()]);
    }

    public function sharePost(Request $request)
    {
        $shared_post = Post::find($request->shared_post_id);
        $user = User::find(auth()->user()->getAuthIdentifier());
        $post = new Post();
        $post->shared = true;
        $post->text_body = $request->text_body;
        $user->posts()->save($post);
        $post->share()->save($shared_post);
    }

    private function storePhotos(Request $request, Post $post)
    {
        if (!$request->photos) {
            return;
        }
        foreach ($request->photos as $photo) {
            $newPhoto = new Photo();
            $newPhoto->url = $photo->store('postPhoto');
            $post->photos()->save($newPhoto);
        }
    }

    private function storeVideos(Request $request, Post $post)
    {
        if (!$request->videos) {
            return;
        }
        foreach ($request->videos as $video) {
            $newVideo = new Video();
            $newVideo->views=0;
            $newVideo->url = $video->store('postVideo');
            $post->videos()->save($newVideo);
        }

    }

    public function storeHashtags(Request $request, Post $post)
    {
        if (!$request->hashtags) {
            return;
        }
        foreach ($request->hashtags as $hashtag) {
            $newHashtag = Hashtag::where('name', '=', $hashtag)->first();
            if (!$newHashtag) {
                $newHashtag = Hashtag::create(['name' => $hashtag]);
            }
            $post->hashtags()->save($newHashtag);
        }
    }

}

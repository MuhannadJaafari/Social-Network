<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(1);// auth()->user();
        $post = new Post();
        $post->text_body = 'hii';// $request->text_body;
        $post = $user->posts()->make($post->getAttributes());
        $photo = new Photo();

//        $request=collect($request);
//        $post_info = $this->helper->filter($request,['user_id,postable_id,postable_type,text,photo_url,video_url']);
//        $post=Post::create($post_info['user_id,postable_id,postable_type,text']);
//        if($post_info['photo_url'])
//        {
//          //TODO
//        }
//        if($post_info['vider_url'])
//        {
//            //TODO
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id);
        return response()->json(
            ['post_text' => $post->text(),
                'post_images_url' => [$post->photos()->url()],
                'post_videos_url' => [$post->videos()->url()]
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param Post $edited_post
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Post $edited_post)
    {
        $post = Post::find($id);
        $this->authorize('isOwner', $post);
        //TODO edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $post = Post::find($request->id);
//        $this->authorize('isOwner',$post);
        $post->delete();
    }

    public function getPosts(Request $request,$id = null)
    {
        $id = $id === null ? $request->id : $id;
        $user = User::find($id);
        $posts = $user->posts()->simplePaginate(3);
        foreach ($posts as $post) {
            $post->photos;
            $post->videos;
        }
        return $posts;
    }

    public function getTimeline(Request $request)
    {
        $user = User::find($request->id);
        $friends = $user->relations()->wherePivot('relation', '=', 'friends')->get();
        $arr = array();
        foreach ($friends as $friend) {
            foreach ($friend->posts as $post) {
                $post->photos;
                $post->videos;
                array_push($arr, $post);
            }
        }
        return $this->helper->paginate(collect($arr)->sortBy('updated_at'),3,null,['path'=>$request->fullUrl()]);
    }
}

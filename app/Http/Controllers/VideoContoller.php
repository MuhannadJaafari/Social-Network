<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoContoller extends Controller
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
     * @return Response
     */
    public function store(Request $request)
    {

        Video::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {   $video=Video::find($request->id);
        return response()->json([
            'videoable_type'=>$video->videoable_type,
            'videoable_id'=>$video->videoable_id,
            'url'=>$video->url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request): JsonResponse
    {
        $video=Video::find($request->id);
        $this->authorize('isOwner',$video);
        $video->url=$request->url;
        $video->update();
        return response()->json(['done']);
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
        $video=Video::find($request->id);
        $this->authorize('isOwner',$video);
        $video->delete();
        return \response()->json(['done']);
    }
}

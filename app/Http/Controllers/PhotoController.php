<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Users\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PhotoController extends Controller
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
    public function store(Request $request)
    {
        Photo::create($request->all());
        return response()->json(['done']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $photo =Photo::find($id);
        return response()->json(['photoable_id'=>$photo->photoable_id,
            'photoable_type'=>$photo->photoable_type,
            'photo_url'=>$photo->url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $photo=Photo::find($request->id);
        $this->authorize($request,$photo);
        $photo->url=$request->url;
        $photo->update();
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
        $photo=Photo::find($request->id);
        $this->authorize('isOwner',$photo);
        $photo->delete();
        return response()->json(['done']);
    }
    public function updateProfilePic(Request $request)
    {
        //TODO
    }
    public function deleteProfilePic(Request $request)
    {
        //TODO
    }
}

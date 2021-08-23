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
    public function updateProfilePic(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $photo = $request->photo;
        $oldPhoto = Photo::where('photo_type', '=', 'profile')->where('current', '=', '1')->first();
        if ($oldPhoto) {
            $oldPhoto->current = 0;
            $oldPhoto->save();
        }
        $newPhoto = new Photo();
        $path = $photo->store(
            'profilePic', 'public_uploads'
        );

        $newPhoto->url = 'https://oneaddressfashion.com' . '/' . $path;
        $newPhoto->photo_type = 'profile';
        $newPhoto->current = 1;
        $user->photo()->save($newPhoto);
    }

    public function updateCoverPic(Request $request)
    {
        $oldPhoto = Photo::where('photo_type', '=', 'cover')->where('current', '=', '1')->first();
        $photo = $request->photo;
        if ($oldPhoto) {
            $oldPhoto->current = 0;
            $oldPhoto->save();
        }
        $newPhoto = new Photo();
        $path = $photo->store(
            'coverPic', 'public_uploads'
        );
        $newPhoto->url = 'https://oneaddressfashion.com' . '/' . $path;
        $newPhoto->photo_type = 'cover';
        $newPhoto->current = 1;
        $user->photo()->save($newPhoto);
    }
}

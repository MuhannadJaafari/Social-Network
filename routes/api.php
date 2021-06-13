<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\PhotoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/{user_id}',[UserController::class,'show']);
Route::get('/{user_id}/profilePic',[UserController::class,'getProfilePic']);
Route::get('/{user_id}/posts',[UserController::class,'getPosts']);
Route::get('/{user_id}/friends',[UserController::class,'getFriends']);
Route::get('/{user_id}/photos',[UserController::class,'getPhotos']);
Route::get('{post_id}/comments',[PostController::class,'getComments']);
Route::get('{post_id}/likes',[PostController::class,'getLikes']);
Route::get('{post_id}/sharers',[PostController::class,'getSharers']);
//protected routes

Route::group(['middleware'=>['auth:sanctum']],function (){
Route::post('/logout',[AuthController::class,'logout']);
Route::delete('/deactivate',[UserController::class,'destroy']);
Route::put('/update',[UserController::class,'destroy']);
Route::post('/newPost',[PostController::class,'store']);
Route::put('/updatePost',[PostController::class,'update']);
Route::delete('/deletePost',[PostController::class,'destroy']);
Route::post('/newComment',[CommentController::class,'store']);
Route::put('/updateComment',[CommentController::class,'update']);
Route::delete('/deleteComment',[CommentController::class,'destroy']);
Route::post('newHashtag',[HashtagController::class,'store']);
Route::post('newLike',[LikeController::class,'store']);
Route::delete('deleteLike',[LikeController::class,'destroy']);
Route::get('/newsFeed',[PostController::class,'getNewsFeed']);
Route::post('/{post}/viewed',[PostController::class,'viewPost']);//for newsFeed algo
Route::put('/updateProfilePic',[PhotoController::class,'updateProfilePic']);
Route::delete('/deleteProfilePic',[PhotoController::class,'deleteProfilePic']);
});

<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\SearchController;
use App\Models\Users\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Route::get('/{user_id}/profilePic', [UserController::class, 'getProfilePic']);
//Route::get('/{user_id}/posts', [UserController::class, 'getPosts']);
//Route::get('/{user_id}/friends', [UserController::class, 'getFriends']);
//Route::get('/{user_id}/photos', [UserController::class, 'getPhotos']);
//Route::get('{post_id}/comments', [PostController::class, 'getComments']);
//Route::get('{post_id}/likes', [PostController::class, 'getLikes']);
//Route::get('{post_id}/sharers', [PostController::class, 'getSharers']);
//protected routes
Route::get('/',function(){
    return User::all();
//   event(new \App\Events\SendMessageEvent('hi dude'));
});
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('user')->group(function () {
        Route::post('/profilePage',[UserController::class,'show']);
        Route::post('/posts', [PostController::class, 'getPosts']);
        Route::post('/timeline', [PostController::class, 'getTimeline']);
        Route::post('/deactivate', [UserController::class, 'destroy']);
        Route::post('/update', [UserController::class, 'update']);
    });

    Route::prefix('relation')->group(function () {
        Route::post('/new', [RelationController::class, 'add']);
        Route::post('/accept', [RelationController::class, 'accept']);
        Route::post('/reject', [RelationController::class, 'delete']);
        Route::post('/unfriend', [RelationController::class, 'delete']);
        Route::post('/block', [RelationController::class, 'block']);
        Route::post('/unblock', [RelationController::class, 'unblock']);
        Route::post('/getRelation', [RelationController::class, 'getCurrentRelation']);
        Route::post('/friendsRequests', [RelationController::class, 'getFriendsRequests']);
        Route::post('/friends', [RelationController::class, 'getFriends']);
    });


    Route::prefix('post')->group(function () {
        Route::post('/new', [PostController::class, 'store']);
        Route::post('/update', [PostController::class, 'update']);
        Route::post('/delete', [PostController::class, 'destroy']);
        Route::post('/comments', [CommentController::class, 'getComments']);
        Route::post('/likes', [LikeController::class, 'getLikes']);
        Route::post('/newLike', [LikeController::class, 'store']);
        Route::post('/unLike', [LikeController::class, 'destroy']);
        Route::post('/newComment', [CommentController::class, 'store']);
        Route::post('/updateComment', [CommentController::class, 'update']);
        Route::post('/deleteComment', [CommentController::class, 'destroy']);//todo
        Route::post('/newReply', [CommentController::class, 'reply']);
        Route::post('/updateReply', [CommentController::class, 'updateReply']);
    });

    Route::post('/search', [SearchController::class, 'search']);


//    Route::post('newHashtag', [HashtagController::class, 'store']);

//    Route::post('/{post}/viewed', [PostController::class, 'viewPost']);//for newsFeed algo
    Route::put('/updateProfilePic', [PhotoController::class, 'updateProfilePic']);
    Route::delete('/deleteProfilePic', [PhotoController::class, 'deleteProfilePic']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::post('/newPage', [PageController::class, 'store']);
    Route::post('/newGroup', [GroupController::class, 'store']);
    Route::post('/addPageRole', [PageController::class, 'addRole']);
    Route::post('/addGroupRole', [GroupController::class, 'addRole']);
    Route::post('/addPagePost', [PageController::class, 'addPagePost']);
    Route::post('/addGroupPost', [GroupController::class, 'addGroupPost']);
    Route::post('/addReply', [CommentController::class, 'reply']);


    Route::post('sendMessage',[\App\Http\Controllers\MessageContoller::class,'store']);
});

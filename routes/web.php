<?php

use App\Http\Controllers\AuthController;
use App\Http\Requests\UserAccountCreatingRequest;
use App\Models\Conversation;
use App\Models\Users\Address;
use App\Models\Users\Username;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use App\Models\Users\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/csrf',function(){
    return csrf_token();
});
Route::get('/',function(){

    return view('welcome');
});
Route::get('/k', function () {
    (new \Illuminate\Pagination\LengthAwarePaginator());
});
Route::view('forgot_passowrd','reset_password')->name('password.reset');

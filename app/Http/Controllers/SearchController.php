<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        if($request->body){
            $users = User::where('name','like','%'.$request->body.'%')
                ->orderBy('name')->get();
            $collection = [];
            foreach($users as $user){
                $user->profilePic = collect($user->photo()->where('current','=','1')->first())->get('url');
                array_push($collection,$user);
            }
            return $collection;
        }
    }
}

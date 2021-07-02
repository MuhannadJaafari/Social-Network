<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $users = User::where('name','like','%'.$request->body.'%')
            ->orderBy('name')->get();
        $users = $this->helper->filter(collect($users),['id','name']);
        return $users;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RelationController extends Controller
{
    public function getCurrentRelation(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user
            ->relations()
            ->where('user1_id',$request->id)
            ->orWhere('user2_id',$request->id)
            ->first();
        if(!$relation){
            $response = [
                'relation'=>'no relation'
            ];
        }else{
            $response = [
                'relation'=>$relation->pivot->relation
            ];
        }
        return response()->json([
            $response
        ]);
    }
    public function add(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user2 = User::find($request->id);
        $user->relations()->save($user2);
        return response()->json([
            'success'=>'1'
        ]);
    }
    public function accept(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user->relations()->where('user1_id',$request->id)->orWhere('user2_id',$request->id)->first()->pivot;
        $relation->relation = 'friends';
        $relation->save();
        return response()->json([
            'success'=>'1'
        ]);
    }
    public function block(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user->relations()->where('user1_id',$request->id)->orWhere('user2_id',$request->id)->first();
        if(!$relation){
            $this->add($request);
        }
        $relation = $user->relations()->where('user1_id',$request->id)->orWhere('user2_id',$request->id)->first()->pivot;
        $relation->relation = 'blocked';
        $relation->blocker = $user->id;
        $relation->save();
        return response()->json([
            'success'=>'1'
        ]);
    }
    public function unblock(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        if(!Gate::allows('can-unblock-user',$user)){
            return response()->json([
                'success'=>'0'
            ]);
        }
        $relation = $user->relations()->where('user1_id',$request->id)->orWhere('user2_id',$request->id)->first()->pivot;
        $relation->delete();
        return response()->json([
            'success'=>'1'
        ]);
    }
    public function delete(Request $request){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $relation = $user->relations()->where('user1_id',$request->id)->orWhere('user2_id',$request->id)->first();
        $relation->delete();
    }
}

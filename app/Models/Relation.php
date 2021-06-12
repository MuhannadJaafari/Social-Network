<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;
    public function sender(){
        return $this->belongsTo(User::class,'user1_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'user2_id');
    }

}


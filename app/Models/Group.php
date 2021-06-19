<?php

namespace App\Models;

use App\Models\Users\Username;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function posts()
    {
        return $this->morphMany(Post::class,'postable');
    }
    public function username()
    {
        return $this->morphOne(Username::class,'useable');
    }
    public function roles(){
        return $this->morphMany(Role::class,'roleable');
    }
}

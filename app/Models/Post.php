<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    public function postable(){
        return $this->morphTo();
    }
//    public function photo() : HasMany{
//        return $this->hasMany(Photo::class);
//    }
//    public function video() : HasMany{
//        return $this->hasMany(Video::class);
//    }
    public function hashtag() : HasMany{
        return $this->hasMany(Hashtag::class);
    }
    public function text(){
        return $this->morphOne(Text::class,'textable');
    }
    public function like() {
        return $this->morphMany(Like::class,'likeable');
    }
    public function comment() :HasMany{
        return $this->hasMany(Comment::class);
    }

}

<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=['reply'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }
    public function video() {
        return $this->morphOne(Video::class,'videoable');
    }
    public function replies()
    {
        return $this->belongsToMany(Comment::class,'replies','reply_id','comment_id');
    }
}

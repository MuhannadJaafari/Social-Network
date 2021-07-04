<?php

namespace App\Models;

use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function username()
    {
        return $this->morphOne(Username::class, 'useable');
    }

    public function roles()
    {
        return $this->morphMany(Role::class, 'roleable');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

}

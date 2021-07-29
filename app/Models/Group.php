<?php

namespace App\Models;

use App\Events\GroupDeleteEvent;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'deleting' => GroupDeleteEvent::class
    ];
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

    public function photo()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}

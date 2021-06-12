<?php

namespace App\Models\Users;

use App\Models\Comment;
use App\Models\Conversation;
use App\Models\Post;
use App\Models\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Database\Eloquent\Relations\HasMany as HasMany;
use \Illuminate\Database\Eloquent\Relations\HasOne as HasOne;

class User extends Authenticate
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function username(): HasOne
    {
        return $this->hasOne(Username::class);
    }

    public function address(): HasOne
    {
        $this->hasOne(Address::class);
    }

    public function relations()
    {
        return Relation::where('user1_id', '=', $this->id)
            ->orWhere('user2_id', '=', $this->id);

    }

    public function conversation(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

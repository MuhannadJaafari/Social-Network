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
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Database\Eloquent\Relations\HasMany as HasMany;
use \Illuminate\Database\Eloquent\Relations\HasOne as HasOne;

class User extends Authenticate
{
    use HasFactory, Notifiable, HasApiTokens;/**
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
        'email',
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function username()
    {
        return $this->morphOne(Username::class,'useable');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class,'user_id');
    }
    public function relations(){
        $relation = $this->belongsToMany(User::class,'relation_user','user2_id','user1_id')->withPivot('relation');
        if($relation->count()){
            return $relation;
        }
        return $this->belongsToMany(User::class,'relation_user','user1_id','user2_id')->withPivot('relation');
    }
    public function conversationas(): HasMany
    {
        $relation = $this->hasMany(Conversation::class,'user1_id')->where('user1_id','=',$this->id);
        if($relation->count()){
            return $relation;
        }
        return $this->hasMany(Conversation::class,'user2_id')->where('user2_id','=',$this->id);

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}

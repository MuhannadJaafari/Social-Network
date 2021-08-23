<?php

namespace App\Models\Users;

use App\Events\UserDeletedEvent;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\Group;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Database\Eloquent\Relations\HasMany as HasMany;
use \Illuminate\Database\Eloquent\Relations\HasOne as HasOne;
use Laravel\Scout\Searchable;

class User extends Authenticate
{
    use HasFactory, Notifiable, HasApiTokens, Searchable;

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
        'email_verified_at',
        'updated_at',
        'created_at',
    ];
    protected $dispatchesEvents = [
        'deleting' => UserDeletedEvent::class
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = array('profilePic','coverPic');
    public $profilePic,$coverPic;
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function username()
    {
        return $this->morphOne(Username::class, 'useable');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'user_id');
    }
    public function getProfilePicAttribute(){
        return $this->profilePic;
    }
    public function getCoverPicAttribute(){
        return $this->coverPic;
    }
    public function relationUser($id1, $id2)
    {
//        SELECT users.id,relation_user.user2_id FROM `users`
//INNER join relation_user
//on users.id = relation_user.user1_id;

//        $relation =
//            return $this->belongsToMany(User::class, 'relation_user', 'user1_id', 'user2_id')->withPivot('relation');
        return $this->belongsToMany(User::class, 'relation_user', $id1, $id2)->withPivot('relation', 'blocker');
//        if ($relation->count()) {
//            return $relation;
//        }
//        return $this->belongsToMany(User::class, 'relation_user', 'user1_id', 'user2_id')->withPivot('relation');
    }

    public function conversations(): HasMany
    {
        $relation = $this->hasMany(Conversation::class, 'user1_id')->where('user1_id', '=', $this->id);
        if ($relation->count()) {
            return $relation;
        }
        return $this->hasMany(Conversation::class, 'user2_id')->where('user2_id', '=', $this->id);

    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_user');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function photo()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

}

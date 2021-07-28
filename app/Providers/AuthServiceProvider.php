<?php

namespace App\Providers;

use App\Models\Photo;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Users\User;
use App\Models\Video;
use App\Policies\CommentPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\VideoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        Photo::class => PhotoPolicy::class,
        Video::class => VideoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('can-view-user', [UserPolicy::class, 'canViewUser']);
        Gate::define('can-unblock-user', [UserPolicy::class, 'canUnblock']);
        Gate::define('can-block-user',[UserPolicy::class,'canBlock']);
    }
}

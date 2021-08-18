<?php

namespace App\Providers;

use App\Events\CommentDeletedEvent;
use App\Events\FriendShipCreatedEvent;
use App\Events\GroupDeleteEvent;
use App\Events\PageDeletedEvent;
use App\Events\PostDeletedEvent;
use App\Events\ReplyDeletedEvent;
use App\Events\UserDeletedEvent;
use App\Listeners\CheckHashtagTable;
use App\Listeners\CommentDeleteRelations;
use App\Listeners\CreateConversationListener;
use App\Listeners\DeleteGroupFromPivotListener;
use App\Listeners\DeletePageFromPivotListener;
use App\Listeners\DeleteUserListener;
use App\Listeners\PostDeleteRelations;
use App\Listeners\ReplyDeletedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostDeletedEvent::class => [
            PostDeleteRelations::class,
            CheckHashtagTable::class
        ],
        CommentDeletedEvent::class => [
            CommentDeleteRelations::class,
            CheckHashtagTable::class
        ],
        UserDeletedEvent::class => [
            DeleteUserListener::class
        ],
        GroupDeleteEvent::class => [
            DeleteGroupFromPivotListener::class
        ],
        PageDeletedEvent::class => [
            DeletePageFromPivotListener::class
        ],
        FriendShipCreatedEvent::class => [
            CreateConversationListener::class
        ],
        ReplyDeletedEvent::class =>[
            ReplyDeletedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

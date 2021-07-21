<?php

namespace App\Providers;

use App\Events\CommentDeletedEvent;
use App\Events\PostDeletedEvent;
use App\Listeners\CheckHashtagTable;
use App\Listeners\CommentDeleteRelations;
use App\Listeners\PostDeleteRelations;
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

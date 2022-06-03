<?php

namespace App\Providers;

use App\Events\CommentPosted;
use App\Events\OrderShipped;
use App\Events\PodcastProcessed;
use App\Listeners\SendCommentPostedNotification;
use App\Listeners\SendPodcastNotification;
use App\Listeners\UserEventSubscriber;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendShipmentNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class    => [
            SendEmailVerificationNotification::class,
        ],
        //OrderShipped::class  => [
        //    SendShipmentNotification::class,
        //],
        CommentPosted::class =>
            [
                SendCommentPostedNotification::class,
            ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventSubscriber::class,
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            PodcastProcessed::class,
            [SendPodcastNotification::class, 'handle']
        );

        Event::listen(queueable(function (PodcastProcessed $event) {

        })->catch(function (PodcastProcessed $event, Throwable $e) {
            // The queued listener failed...
        })
            ->onConnection('redis')
            ->onQueue('podcasts')
            ->delay(now()->addSeconds(10))
        );

        //Event::listen(function (PodcastProcessed $event) {
        //    //
        //});

        Event::listen('event.*', function ($eventName, array $data) {
            //
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            $this->app->path('Listeners'),
        ];
    }
    //For production
    //event:cache, event:clear
}

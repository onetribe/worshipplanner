<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\Observers\SetObserver;
use App\Observers\SongObserver;
use App\Set;
use App\Song;
use App\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        User::observe(UserObserver::class);
        Set::observe(SetObserver::class);
        Song::observe(SongObserver::class);
    }
}

<?php

namespace App\Providers;

use App\Observers\AuthorObserver;
use App\Observers\BandObserver;
use App\Observers\BandRoleObserver;
use App\Observers\InviteLinkObserver;
use App\Observers\ServiceObserver;
use App\Observers\SetObserver;
use App\Observers\SetSongObserver;
use App\Observers\SongObserver;
use App\Observers\TeamObserver;
use App\Observers\UserObserver;
use App\Author;
use App\Band;
use App\BandRole;
use App\InviteLink;
use App\Service;
use App\Set;
use App\SetSong;
use App\Song;
use App\Team;
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
        SetSong::observe(SetSongObserver::class);
        Team::observe(TeamObserver::class);
        Service::observe(ServiceObserver::class);
        Band::observe(BandObserver::class);
        BandRole::observe(BandRoleObserver::class);
        Author::observe(AuthorObserver::class);
        InviteLink::observe(InviteLinkObserver::class);
    }
}

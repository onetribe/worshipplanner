<?php

namespace App\Providers;

use App\Band;
use App\BandRole;
use App\Set;
use App\SetSong;
use App\Song;
use App\Team;
use App\TeamSubscription;
use App\User;
use App\Policies\DefaultTeamAuthPolicy;
use App\Policies\SetPolicy;
use App\Policies\SetSongPolicy;
use App\Policies\SongPolicy;
use App\Policies\TeamPolicy;
use App\Policies\TeamSubscriptionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Set::class => SetPolicy::class,
        Song::class => SongPolicy::class,
        SetSong::class => SetSongPolicy::class,
        BandRole::class => DefaultTeamAuthPolicy::class,
        Band::class => DefaultTeamAuthPolicy::class,
        User::class => UserPolicy::class,
        TeamSubscription::class => TeamSubscriptionPolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

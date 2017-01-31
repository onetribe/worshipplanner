<?php

namespace App\Services;

use App\Team;
use Illuminate\Auth\AuthManager;
use Session;

class ActiveTeam
{
    /**
     * @var App\Team
     **/
    protected $activeTeam;

    /**
     * @var Illuminate\Auth\AuthManager
     **/
    protected $auth;

    /**
     * @param AuthManager $auth
     * @return void
     **/
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get the currently active team from the session
     *
     * @return App\Team
     **/
    public function get()
    {
        if (! $this->activeTeam) {
            if ($teamId = Session::get('team_id')) {
                $this->activeTeam = Team::find($teamId);    
            } else {
                $this->activeTeam = $this->getForUser();
            }
        }

        return $this->activeTeam;
    }

    /**
     * Sets the currently active team
     *
     * @param  App\Team $team
     * @param  App\User $user
     * 
     * @return void
     **/
    public function set(Team $team, $user)
    {
        Session::put('team_id', $team->id);
        
        $user->lastTeam()->associate($team)->save();

        $this->activeTeam = $team;
    }


    /**
     * Gets the active team for the user. Look in the last last used ID first,
     * otherwise just use the first team
     *
     * @param App\User $user
     * @return App\Team
     **/
    public function getForUser($user = null)
    {
        $user = $user ?: $this->auth->user();

        // Get team ID from the last team the user had selected
        if ($user->last_team_id) {
            return $user->lastTeam;
        }

        // Get team ID from the first team that the user is a part of 
        if ($team = $user->teams->first()) {
            return $team;
        }
    }
}

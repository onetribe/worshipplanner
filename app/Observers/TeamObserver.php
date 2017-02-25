<?php

namespace App\Observers;

use App\Team;
use Illuminate\Auth\AuthManager;

class TeamObserver
{
    use StripsTagsFromFields;

    /**
     * @var Illuminate\Auth\AuthManager $auth
     **/
    protected $auth;

    /**
     * @param Illuminate\Auth\AuthManager $auth
     * @return void
     **/
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Listen to the Team saving event.
     *
     * @param App\Team $set
     * @return void
     */
    public function saving(Team $team)
    {
        $this->stripTags($team, ['title', 'country_code']);
    }

    /**
     * Listen to the Team creating event.
     *
     * @param App\Team $team
     * @return bool|null
     */
    public function creating(Team $team)
    {
        $team->creator_id = $this->auth->user()->id;
        $team->access_code = md5(uniqid($this->auth->user()->email, true));
    }

}
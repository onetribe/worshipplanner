<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Services\DateHelperInterface;
use App\Set;
use Illuminate\Auth\AuthManager;

class SetObserver
{
    use SetsActiveTeamOnCreateTrait;

    /**
     * @var App\Services\DateHelperInterface $dateHelper
     **/
    protected $dateHelper;

    /**
     * @var Illuminate\Auth\AuthManager $auth
     **/
    protected $auth;

    /**
     * @param App\Services\DateHelperInterface $dateHelper
     * @param App\Services\ActiveTeam $activeTeam
     * @param Illuminate\Auth\AuthManager $auth
     * @return void
     **/
    public function __construct(
        DateHelperInterface $dateHelper, 
        ActiveTeam $activeTeam,
        AuthManager $auth
    )
    {
        $this->dateHelper = $dateHelper;
        $this->activeTeam = $activeTeam;
        $this->auth = $auth;
    }

    /**
     * Listen to the Set saving event.
     *
     * @param App\Set $set
     * @return void
     */
    public function saving(Set $set)
    {
        $set->when = $this->dateHelper->toUTC($set->when);

        if (is_null($set->description)) {
            $set->description = "";
        }

        return true;
    }

    /**
     * Listen to the Set creating event.
     *
     * @param App\Set $set
     * @return bool|null
     */
    public function creating(Set $set)
    {
        $set->creator_id = $this->auth->user()->id;

        return $this->setTeamOnCreating($set);
    }

}
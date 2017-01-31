<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Services\DateHelperInterface;
use App\Set;

class SetObserver
{
    /**
     * @var DateHelperInterface $dateHelper
     **/
    protected $dateHelper;

    /**
     * @var ActiveTeam $activeTeam
     **/
    protected $activeTeam;

    /**
     * @param DateHelperInterface $dateHelper
     * @param ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(DateHelperInterface $dateHelper, ActiveTeam $activeTeam)
    {
        $this->dateHelper = $dateHelper;
        $this->activeTeam = $activeTeam;
    }

    /**
     * Listen to the Set saving event.
     *
     * @param Set $set
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
     * @param Set $set
     * @return bool|null
     */
    public function creating(Set $set)
    {
        if ($team = $this->activeTeam->get()) {
            $set->team_id = $team->id;
            return true;
        } else {
            return false;
        }
    }

}
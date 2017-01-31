<?php

namespace App\Observers;

use App\Song;

trait SetsActiveTeamOnCreateTrait
{

    /**
     * @var ActiveTeam $activeTeam
     **/
    protected $activeTeam;

    /**
     * @param Song $song
     * @return bool|null
     */
    public function setTeamOnCreating(Song $song)
    {
        if ($team = $this->activeTeam->get()) {
            $song->team_id = $team->id;
            return true;
        } else {
            return false;
        }
    }

}
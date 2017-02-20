<?php

namespace App\Observers;

trait SetsActiveTeamOnCreateTrait
{

    /**
     * @var ActiveTeam $activeTeam
     **/
    protected $activeTeam;

    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     */
    public function setTeamOnCreating($model)
    {
        if ($team = $this->activeTeam->get()) {
            $model->team_id = $team->id;
            return true;
        } else {
            return false;
        }
    }

}
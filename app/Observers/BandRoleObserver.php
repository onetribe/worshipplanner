<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\BandRole;

class BandRoleObserver
{
    use SetsActiveTeamOnCreateTrait, StripsTagsFromFields;

    /**
     * @param App\Services\ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
    }

    /**
     * Listen to the BandRole saving event.
     *
     * @param App\BandRole $bandRole
     * @return void
     */
    public function saving(BandRole $bandRole)
    {
        $this->stripTags($bandRole, ['title']);

        return true;
    }

    /**
     * Listen to the BandRole creating event.
     *
     * @param App\BandRole $set
     * @return bool|null
     */
    public function creating(BandRole $bandRole)
    {
        return $this->setTeamOnCreating($bandRole);
    }

}
<?php

namespace App\Observers;

use App\Band;
use App\Services\ActiveTeam;

class BandObserver
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
     * Listen to the Band saving event.
     *
     * @param App\Band $band
     * @return void
     */
    public function saving(Band $band)
    {
        $this->stripTags($band, ['title']);
    }

    /**
     * Listen to the Band creating event.
     *
     * @param Band $band
     * @return bool|null
     */
    public function creating(Band $band)
    {
        return $this->setTeamOnCreating($band);
    }
}
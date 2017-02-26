<?php

namespace App\Observers;

use App\InviteLink;
use App\Services\ActiveTeam;

class InviteLinkObserver
{
    use SetsActiveTeamOnCreateTrait;

    /**
     * @param App\Services\ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
    }

    /**
     * Listen to the InviteLink creating event.
     *
     * @param App\InviteLink $link
     * @return bool|null
     */
    public function creating(InviteLink $link)
    {
        return $this->setTeamOnCreating($link);
    }

}
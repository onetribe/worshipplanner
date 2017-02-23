<?php

namespace App\Observers;

use App\Service;
use App\Services\ActiveTeam;

class ServiceObserver
{
    use StripsTagsFromFields, SetsActiveTeamOnCreateTrait;

    /**
     * @param App\Services\ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
    }

    /**
     * Listen to the Service saving event.
     *
     * @param App\Service $service
     * @return void
     */
    public function saving(Service $service)
    {
        $this->stripTags($service, ['title']);
    }

    /**
     * Listen to the Service creating event.
     *
     * @param Service $service
     * @return bool|null
     */
    public function creating(Service $service)
    {
        return $this->setTeamOnCreating($service);
    }
}
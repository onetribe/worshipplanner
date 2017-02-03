<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Author;

class AuthorObserver
{
    use SetsActiveTeamOnCreateTrait;

    /**
     * @param App\Services\ActiveTeam $activeTeam
     *
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
    }

    /**
     * Listen to the Author creating event.
     *
     * @param App\Author $author
     *
     * @return bool|null
     */
    public function creating(Author $author)
    {
        return $this->setTeamOnCreating($author);
    }

}
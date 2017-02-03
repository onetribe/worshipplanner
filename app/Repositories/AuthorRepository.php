<?php

namespace App\Repositories;

use App\Author;
use App\Team;

class AuthorRepository extends AbstractRepository
{
    /**
     * @param string
     * @return void
     **/
    public function __construct()
    {
        $this->model = new Author;
    }


    /**
     * Get all authors for the given team
     *
     * @param App\Team $team
     *
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function getAllForTeam(Team $team)
    {
        return $this->newQueryWithoutScopes()
            ->whereNull('team_id')
            ->orWhere('team_id', $team->id)
            ->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('middle_name', 'ASC')
            ->get();
    }

}

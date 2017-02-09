<?php

namespace App\Repositories;

use App\SetSong;
use App\Team;

class SetSongRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->model = new SetSong;
    }

}

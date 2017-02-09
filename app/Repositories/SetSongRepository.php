<?php

namespace App\Repositories;

use App\SetSong;

class SetSongRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->model = new SetSong;
    }

}

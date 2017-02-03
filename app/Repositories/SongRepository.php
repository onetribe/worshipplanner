<?php

namespace App\Repositories;

use App\Song;
use App\Team;

class SongRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->model = new Song;
    }

    /**
     * Returns all songs for the current team, ordered
     *
     * @param array $with
     *
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function getAllOrdered(array $with = null)
    {
    	$q = $this->orderBy('title', 'ASC')
            ->orderBy('alternative_title', 'ASC');
        
        if (! is_null($with)) {
        	$q->with($with);
        }

        return $q->get();
    }

}

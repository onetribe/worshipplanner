<?php

namespace App\Repositories;

use App\Set;

class SetRepository extends AbstractRepository
{

    public function __construct()
    {
        $this->model = new Set;
    }

}

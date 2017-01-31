<?php

namespace App\Repositories;

use App\Service;

class ServicesRepository extends AbstractRepository
{
    /**
     * @param string
     * @return void
     **/
    public function __construct()
    {
        $this->model = new Service;
    }
}
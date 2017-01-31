<?php

namespace App\Repositories;

use App\Author;

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

}

<?php

namespace App\Repositories;

interface RepositoryInterface
{
   
    /**
     * Returns the model instance
     *
     * @return Illuminate\Database\Eloquent\Model
     **/
    public function getModel();
}
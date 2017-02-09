<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    /**
     * @var Illuminate\Eloquent\Database\Model
     **/
    protected $model;

    /**
     * Returns the model instance
     *
     * @return Illuminate\Database\Eloquent\Model
     **/
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Handle dynamic method calls by passing to the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->model, $method], $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([$this->model, $method], $parameters);
    }
}
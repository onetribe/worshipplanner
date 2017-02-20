<?php

namespace App\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserPolicy
{

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function view(User $user, Model $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        return $this->view($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return $this->view($user, $model);
    }
}

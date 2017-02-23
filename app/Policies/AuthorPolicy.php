<?php

namespace App\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AuthorPolicy extends AbstractTeamAuthPolicy
{

    /**
     * Determine whether the user can update the author.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        //can't update default authors
        if (is_null($model->team_id)) {
            return false;
        }

        return $this->handleUpdate($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return $this->update($user, $model);
    }
}

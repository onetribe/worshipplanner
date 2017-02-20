<?php

namespace App\Policies;

use App\User;
use App\Song;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamSubscriptionPolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

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
        if($this->handleUpdate($user, $model)) {
        	return true;
        }

        if ($model->user_id == $user->id) {
        	return true;
        }

        return false;
    }
}
<?php

namespace App\Policies;

use App\User;
use App\SetSong;
use Illuminate\Database\Eloquent\Model;

class SetSongPolicy extends AbstractTeamAuthPolicy
{

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $setSong
     *
     * @return mixed
     */
    public function view(User $user, Model $setSong)
    {
        return $this->handleView($user, $setSong->set);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model $setSong
     *
     * @return mixed
     */
    public function update(User $user, Model $setSong)
    {
        return $this->handleUpdate($user, $setSong->set);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model $setSong
     *
     * @return mixed
     */
    public function delete(User $user, Model $setSong)
    {
        return $this->handleDelete($user, $setSong->set);
    }
}

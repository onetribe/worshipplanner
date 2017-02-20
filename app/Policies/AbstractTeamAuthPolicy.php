<?php

namespace App\Policies;

use App\Services\ActiveTeam;
use App\Team;
use App\User;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractTeamAuthPolicy
{
    /**
     * @var ActiveTeam $activeTeam
     **/
    protected $activeTeam;

    /**
     * @param ActiveTeam $activeTeam
     *
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
    }

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create sets.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->handleCreate($user);
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
        return $this->handleView($user, $model);
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
        return $this->handleUpdate($user, $model);
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
        return $this->handleDelete($user, $model);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    protected function handleView(User $user, Model $model)
    {
        if ($user->teams->count() == 0) {
            return false;
        }

        $teamIds = $user->teams->pluck('id')->toArray();
        
        return in_array($model->team_id, $teamIds);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     *
     * @return mixed
     */
    protected function handleCreate(User $user)
    {
        if ($user->teamSubscriptions->count() == 0) {
            return false;
        }

        foreach ($user->teamSubscriptions as $teamSubscription) {
            if ($teamSubscription->isAdmin() && $this->activeTeam->id == $teamSubscription->team_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the song.
     *
     * @param  \App\User  $user
     * @param  Illuminate\Database\Eloquent\Model $model
     *
     * @return mixed
     */
    protected function handleUpdate(User $user, Model $model)
    {
        if ($user->teamSubscriptions->count() == 0) {
            return false;
        }

        foreach ($user->teamSubscriptions as $teamSubscription) {
            if ($teamSubscription->isAdmin() && $teamSubscription->team_id == $model->team_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  App\User  $user
     * @param  Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    protected function handleDelete(User $user, Model $model)
    {
        return $this->handleUpdate($user, $model);
    }
}

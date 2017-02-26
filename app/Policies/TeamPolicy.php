<?php

namespace App\Policies;

use App\User;
use App\Team;

class TeamPolicy
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
     * @param  \App\Team  $model
     * @return bool
     */
    public function view(User $user, Team $team)
    {
        foreach ($user->teams as $userTeam) {
            if ($userTeam->id == $team->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $model
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        if ($user->teamSubscriptions->count() == 0) {
            return false;
        }

        foreach ($user->teamSubscriptions as $teamSubscription) {
            if ($teamSubscription->isAdmin() && $team->id == $teamSubscription->team_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $model
     * @return bool
     */
    public function delete(User $user, Team $team)
    {
        return $this->update($user, $team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $model
     * @return bool
     */
    public function leave(User $user, Team $team)
    {
        if ($user->teamSubscriptions->count() == 0) {
            return false;
        }

        foreach ($user->teamSubscriptions as $teamSubscription) {
            if ($teamSubscription->isAdmin() && $team->id == $teamSubscription->team_id) {
                return true;
            }
            if ($teamSubscription->user_id == $user->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can activate the given team as their active team.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $model
     * @return bool
     */
    public function activate(User $user, Team $team)
    {
        if ($user->teamSubscriptions->count() == 0) {
            return false;
        }

        return $user->teamSubscriptions
            ->pluck('team_id')
            ->contains($team->id);
    }

    /**
     * Determine whether the user can invite other members
     *
     * @param  \App\User  $user
     * @param  \App\Team  $model
     * @return bool
     */
    public function invite(User $user, Team $team)
    {
        return $this->update($user, $team);
    }
}

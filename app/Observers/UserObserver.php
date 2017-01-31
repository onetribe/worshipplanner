<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Listen to the User saving event.
     *
     * @param  User  $user
     * @return void
     */
    public function saving(User $user)
    {
        if (is_null($user->timezone)) {
            $user->timezone = "UTC";
        }
    }

}
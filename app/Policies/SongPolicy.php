<?php

namespace App\Policies;

use App\User;
use App\Song;
use Illuminate\Auth\Access\HandlesAuthorization;

class SongPolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

}

<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SetPolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

}

<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DefaultTeamAuthPolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

}

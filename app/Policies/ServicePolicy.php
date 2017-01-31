<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

}

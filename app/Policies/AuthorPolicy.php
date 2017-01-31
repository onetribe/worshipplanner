<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy extends AbstractTeamAuthPolicy
{
    use HandlesAuthorization;

}

<?php

namespace App\Http\Controllers;

use Auth;
use App\BandRole;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class UserBandRolesController extends AbstractApiController
{
    use HandlesAuthorization;

	/**
	 * @param App\Transformers\BasicTransformer $bandRoleTransformer
	 * @return void
	 **/
	public function __construct()
	{
		$this->middleware('auth');
	}


    /**
     * Removes the given band role from the given user
     *
     * @param App\BandRole $bandRole
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, User $user, BandRole $bandRole)
    {
        $this->authorizeCheck($user, $bandRole);

        $user->bandRoles()->detach($bandRole);

        $data = [
            'meta' => [
                'message' => trans('common.removed_successfully'),
            ],
        ];
        return response()->json($data);   
    }

    /**
     * Adds the given band role to the given user
     *
     * @param App\BandRole $bandRole
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, User $user, BandRole $bandRole)
    {
        $this->authorizeCheck($user, $bandRole);

        $user->bandRoles()->attach($bandRole);

        $data = [
            'meta' => [
                'message' => trans('common.added_successfully'),
            ],
        ];
        return response()->json($data);   
    }

    /**
     * Checks whether the auth user is allowed to perform this action
     *
     * @param App\User $user
     * @param App\BandRole $bandRole
     * @return bool
     **/
    private function authorizeCheck($user, $bandRole)
    {
        $authUser = Auth::user();
        if ($user->id == $authUser->id) {
            return true;
        }

        if ($authUser->isAdminForTeam($bandRole->team_id)) {
            return true;
        }

        $this->deny();
    }

}
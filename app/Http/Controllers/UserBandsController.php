<?php

namespace App\Http\Controllers;

use Auth;
use App\Band;
use App\BandRole;
use App\BandSubscription;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class UserBandsController extends AbstractApiController
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
     * Removes the given user from the given band
     *
     * @param App\Band $band
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, Band $band, User $user)
    {
        $this->authorizeCheck($user, $band);

        BandSubscription::where(['user_id' => $user->id, 'band_id' => $band->id])->delete();

        $data = [
            'meta' => [
                'message' => trans('common.removed_successfully'),
            ],
        ];
        return response()->json($data);   
    }

    /**
     * Adds the given user to the given band
     *
     * @param App\Band $band
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Band $band, User $user)
    {
        $this->authorizeCheck($user, $band);

        BandSubscription::create(['user_id' => $user->id, 'band_id' => $band->id]);

        $data = [
            'meta' => [
                'message' => trans('common.added_successfully'),
            ],
        ];
        return response()->json($data);   
    }

    /**
     * Remove the given band role from the given user for this band
     *
     * @param App\Band $band
     * @param App\User $user
     * @param App\BandRole $bandRole
     * @return \Illuminate\Http\Response
     */
    public function removeBandRole(Request $request, Band $band, User $user, BandRole $bandRole)
    {
        $this->authorizeCheck($user, $band);

        $bandSubscription = BandSubscription::where(['user_id' => $user->id, 'band_id' => $band->id])->first();

        $bandSubscription->bandRoles()->detach($bandRole);

        $data = [
            'meta' => [
                'message' => trans('common.removed_successfully'),
            ],
        ];
        return response()->json($data);   
    }

    /**
     * Adds the given band role to the given user for this band
     *
     * @param App\Band $band
     * @param App\User $user
     * @param App\BandRole $bandRole
     * @return \Illuminate\Http\Response
     */
    public function addBandRole(Request $request, Band $band, User $user, BandRole $bandRole)
    {
        $this->authorizeCheck($user, $band);

        $bandSubscription = BandSubscription::where(['user_id' => $user->id, 'band_id' => $band->id])->first();

        $bandSubscription->bandRoles()->attach($bandRole);

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
     * @param App\Band $band
     * @return bool
     **/
    private function authorizeCheck($user, $band)
    {
        $authUser = Auth::user();
        if ($user->id == $authUser->id) {
            return true;
        }

        if ($authUser->isAdminForTeam($band->team_id)) {
            return true;
        }

        $this->deny();
    }

}
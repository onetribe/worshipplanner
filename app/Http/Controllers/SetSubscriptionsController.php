<?php

namespace App\Http\Controllers;

use App\BandRole;
use App\Set;
use App\SetSubscription;
use App\User;
use Illuminate\Http\Request;

class SetSubscriptionsController extends AbstractApiController
{

    /**
     * @return void
     **/
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Creates a new set subscription with the band role the user has
     *
     * @param Illuminate\Http\Request $request
     * @param App\Set $set
     * @param App\User $user
     * @param App\BandRole $bandRole
     * @return Illuminate\Http\JsonResponse
     **/
    public function storeWithRole(Request $request, Set $set, User $user, BandRole $bandRole)
    {
        $subscription = SetSubscription::where(['set_id' => $set->id, 'user_id' => $user->id])->first();

        if (! $subscription) {
            $subscription = SetSubscription::create([
                'set_id' => $set->id,
                'user_id' => $user->id,
            ]);
        }

        if (! $subscription->bandRoles->find($bandRole)) {
            $subscription->bandRoles()->attach($bandRole);
        }
        
        $data = [
            'meta' => [
                'message' => trans('common.added_successfully'),
            ],
        ];
        return response()->json($data); 
    }

    /**
     * Removes the given band role, and if it's the last role to be removed, remove the subscription
     *
     * @param Illuminate\Http\Request $request
     * @param App\Set $set
     * @param App\BandRole $bandRole
     * @return Illuminate\Http\JsonResponse
     **/
    public function removeByRole(Request $request, Set $set, BandRole $bandRole)
    {
        $subscription = SetSubscription::where(['set_id' => $set->id])->whereHas('bandRoles', function ($q) use ($bandRole) {
            $q->where('id', $bandRole->id);
        })->first();

        if ($subscription->bandRoles->count() > 1) {
            $subscription->bandRoles()->detach($bandRole);
        } elseif ($subscription->bandRoles->count() == 1) {
            $subscription->delete();
        }

        $data = [
            'meta' => [
                'message' => trans('common.removed_successfully'),
            ],
        ];
        return response()->json($data); 
    }
}

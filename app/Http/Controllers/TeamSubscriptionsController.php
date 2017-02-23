<?php

namespace App\Http\Controllers;

use Auth;
use App\Scopes\TeamScope;
use App\Services\ActiveTeam;
use App\Team;
use App\TeamSubscription;
use App\Transformers\TeamSubscriptionTransformer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TeamSubscriptionsController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'team_id',
        'user_id',
        'role',
    ];

    /**
     * @param App\Transformers\TeamSubscriptionTransformer $teamSubscriptionTransformer
     * @return void
     **/
    public function __construct(TeamSubscriptionTransformer $teamSubscriptionTransformer)
    {
        $this->middleware('auth');
        $this->model = new TeamSubscription;
        $this->transformer = $teamSubscriptionTransformer;
    }


    /**
     * Display all TeamSubscriptions for the active team.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse
    {
        TeamSubscription::addGlobalScope(new TeamScope);

        return parent::index($request);
    }

    /**
     * Remove the specified TeamSubscription.
     *
     * @param Illuminate\Http\Request $request
     * @param App\TeamSubscription $teamSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TeamSubscription $teamSubscription)
    {

        return $this->apiDestroy($request, $teamSubscription);
    }

    /**
     * Add the given user to the given team.
     *
     * @param Illuminate\Http\Request $request
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, User $user)
    {
        $team = app(ActiveTeam::class)->get();
        $this->authorizeCheck($user, $team);

        $user->teams()->attach($team, ['role' => 2]);

        $data = [
            'meta' => [
                'message' => trans('common.added_successfully'),
            ],
        ];
        return response()->json($data);  
        
    }

    /**
     * Remove the given user from the given team.
     *
     * @param Illuminate\Http\Request $request
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, User $user)
    {
        $team = app(ActiveTeam::class)->get();
        $this->authorizeCheck($user, $team);

        $user->teams()->detach($team);

        $data = [
            'meta' => [
                'message' => trans('common.removed_successfully'),
            ],
        ];
        return response()->json($data);  
        
    }

    /**
     * Change the role of the user in the active team
     *
     * @param Illuminate\Http\Request $request
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function changeRole(Request $request, User $user)
    {
        $team = app(ActiveTeam::class)->get();
        if (! Auth::user()->isAdminForTeam($team->id)) {
            $this->deny();
        }
        
        $message = trans('teams.couldnt_change_role');
        $status = Response::HTTP_UNPROCESSABLE_ENTITY;

        foreach ($user->teamSubscriptions as $teamSubscription) {
            if ($teamSubscription->team_id == $team->id
                && $newRole = $teamSubscription->getRoleFromName($request->get('role'))
            ) {
                $teamSubscription->role = $newRole;
                $teamSubscription->save();
                $message = trans('teams.successfully_changed_role');
                $status = Response::HTTP_OK;
            }
        }

        $data = [
            'meta' => [
                'message' => $message,
            ],
        ];

        return response()->json($data, $status);  
    }

    /**
     * Checks whether the auth user is allowed to perform this action
     *
     * @param App\User $user
     * @param App\Team $team
     * @return bool
     **/
    private function authorizeCheck($user, $team)
    {
        $authUser = Auth::user();
        if ($user->id == $authUser->id) {
            return true;
        }

        if ($authUser->isAdminForTeam($team->id)) {
            return true;
        }

        $this->deny();
    }

}
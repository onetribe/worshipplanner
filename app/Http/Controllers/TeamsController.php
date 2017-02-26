<?php

namespace App\Http\Controllers;

use Auth;
use App\InviteLink;
use App\Mail\SendTeamInvite;
use App\Services\ActiveTeam;
use App\Team;
use App\TeamSubscription;
use App\Transformers\TeamTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamsController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'title',
        'country_code',
    ];

	/**
	 * @param App\Transformers\TeamTransformer $teamTransformer
	 * @return void
	 **/
	public function __construct(TeamTransformer $teamTransformer)
	{
		$this->middleware('auth');
		$this->model = new Team;
		$this->transformer = $teamTransformer;
	}


    /**
     * Display the specified Team.
     *
     * @param Illuminate\Http\Request $request
     * @param App\Team $team
     * @return \Illuminate\Http\Response
     */
    public function leave(Request $request, Team $team)
    {
        $user = Auth::user();
        
        $wasActiveTeam = false;
        if (app(ActiveTeam::class)->get()->id == $team->id) {
            $wasActiveTeam = true;
            if ($firstTeam = $user->teams->first()) {
                app(ActiveTeam::class)->set($firstTeam, $user);    
            }
        }
        
        $user->teams()->detach($team);

        $data = [
            'meta' => [
                'wasActiveTeam' => $wasActiveTeam,
                'message' => trans('teams.success_removed'),
            ],
        ];

        return response()->json($data);
    }

    /**
     * Activate the specified Team as the active team
     *
     * @param Illuminate\Http\Request $request
     * @param App\Team $team
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request, Team $team)
    {
        app(ActiveTeam::class)->set($team, Auth::user());

        return redirect()->route('home');
    }

    /**
     * Creates a new team and subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $response = parent::store($request);

        $newTeamData = $response->getData(true);

        TeamSubscription::create([
            'user_id' => Auth::user()->id,
            'team_id' => $newTeamData['data']['id'],
            'role' => TeamSubscription::ROLE_ADMIN,
        ]);

        $newTeamData['meta']['message'] = trans('teams.created_successfully');
        $response->setData($newTeamData);

        return $response;
    }
}
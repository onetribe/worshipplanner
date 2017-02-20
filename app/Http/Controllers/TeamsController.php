<?php

namespace App\Http\Controllers;

use Auth;
use App\Team;
use App\Transformers\TeamTransformer;
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
        $user->teams()->detach($team);

        $data = [
            'meta' => [
                'message' => trans('teams.success_removed'),
            ],
        ];

        return response()->json($data);
    }

}
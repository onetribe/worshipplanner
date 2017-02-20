<?php

namespace App\Http\Controllers;

use App\TeamSubscription;
use App\Transformers\TeamSubscriptionTransformer;
use Illuminate\Http\Request;
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
     * Display the specified TeamSubscription.
     *
     * @param App\TeamSubscription $teamSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TeamSubscription $teamSubscription)
    {

        return $this->apiDestroy($request, $teamSubscription);
    }

}
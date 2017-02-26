<?php

namespace App\Http\Controllers;

use App\InviteLink;
use App\Mail\SendTeamInvite;
use App\Team;
use App\TeamSubscription;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InviteLinksController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'email',
        'token',
    ];

	/**
	 * @return void
	 **/
	public function __construct()
	{
		$this->middleware('auth')->only('invite');
	}

    /**
     * Invite someone to the given team
     *
     * @param Illuminate\Http\Request $request
     * @param App\Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request, Team $team) : JsonResponse
    {
        $invite_link = new InviteLink;
        $invite_link->token = $invite_link->generateToken();

        $invite_link->email = $request->get('email');
        $invite_link->save();

        $teamInviteMail = new SendTeamInvite(
            $team, 
            route('invite.accept', [
                'team' => $team, 
                'email' => $invite_link->email, 
                'token' => $invite_link->token
            ])
        );
        
        Mail::to($invite_link->email)
            ->send($teamInviteMail);

        $data = [
            'meta' => [
                'message' => trans('teams.success_invited', ['email' => $invite_link->email]),
            ],
        ];

        return response()->json($data);
    }

    /**
     * Accept a team invite
     *
     * @param Illuminate\Http\Request $request
     * @param App\Team $team
     * @param string $email
     * @param string $token
     * @return Illuminate\View\View
     */
    public function accept(Request $request, Team $team, $email, $token)
    {
        $query = (new InviteLink)->newQueryWithoutScopes();
        if (! $link = $query->where(['team_id' => $team->id, 'email' => $email, 'token' => $token])->get()->last()) {
            abort(403);
        }

        if ($link->hasExpired()) {
            $request->session()->flash('alert-failure', trans('teams.link_expired'));
            return redirect('/login');
        }

        $user = User::where('email', $email)->first();

        $userExists = $user ? true : false;

        return view('invite_accept', compact('team', 'userExists', 'email', 'token'));
    }

    /**
     * POST: Accept a team invite
     *
     * @param Illuminate\Http\Request $request
     * @param App\Team $team
     * @param string $email
     * @param string $token
     * @return Illuminate\Http\RedirectResponse
     */
    public function acceptConfirm(Request $request, Team $team, $email, $token) : RedirectResponse
    {
        $query = (new InviteLink)->newQueryWithoutScopes();
        if (! $link = $query->where(['team_id' => $team->id, 'email' => $email, 'token' => $token])->first()) {
            abort(403);
        }

        if ($link->hasExpired()) {
            $request->session()->flash('alert-failure', trans('teams.link_expired'));
            return redirect('/login');
        }

        if (! $user = User::where('email', $email)->first()) {
            $rules = (new User)->getValidationRules();
            $data = $request->all();
            Validator::make($data, $rules)->validate();
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }

        TeamSubscription::create([
            'team_id' => $link->team_id,
            'user_id' => $user->id,
        ]);

        $request->session()->flash('alert-success', trans('teams.added_to_team'));

        return redirect('/');
    }

}
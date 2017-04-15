<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Events\TeamCreated;
use App\Http\Controllers\Controller;
use App\Team;
use App\TeamSubscription;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'team_title' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @param  App\User  $user
     * @return User
     */
    protected function createTeam(array $data, $user)
    {
        return Team::create([
            'title' => $data['team_title'],
            'country_code' => $data['country_code'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //TODO: Registration is temporarily disabled
        return response();

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createUser($request->only(['first_name', 'last_name', 'email', 'password']))));    
        event(new TeamCreated($team = $this->createTeam($request->only(['team_title', 'country_code']), $user)));

        $this->guard()->login($user);

        TeamSubscription::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'role' => TeamSubscription::ROLE_ADMIN,
        ]);

        $user->update(['last_team_id' => $team->id]);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}

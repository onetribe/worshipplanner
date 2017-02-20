<?php

namespace App\Http\Controllers;

use Auth;
use App\BandRole;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Displays user settings
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        $user->load(['teamSubscriptions', 'teamSubscriptions.team', 'bandRoles']);

        $bandRoles = BandRole::all();

        return view('settings.me', compact('user', 'bandRoles'));
    }

}

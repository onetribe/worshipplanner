<?php

namespace App\Http\Controllers;

use Auth;
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

        $user->load(['teamSubscriptions', 'teamSubscriptions.team']);

        return view('settings.me', compact('user'));
    }

}

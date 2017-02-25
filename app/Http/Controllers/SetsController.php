<?php

namespace App\Http\Controllers;

use App\Band;
use App\BandRole;
use App\Repositories\SetRepository;
use App\Set;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SetsController extends Controller
{

    /**
     * @param SetRepository $setRepo
     * @return void
     **/
    public function __construct(SetRepository $setRepo)
    {
        $this->middleware('auth');
        $this->validationRules = $setRepo->getModel()->getValidationRules();
    }

    /**
     * Displays all sets
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        $futureSets = Set::where('when', ">", $now)->orderBy('when', 'ASC')->get();
        $pastSets = Set::where('when', "<=", $now)->orderBy('when', 'DESC')->get();

        return view('sets.index', compact('futureSets', 'pastSets', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created set in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        Set::create($this->transformInput($request));

        return redirect()->route('sets.index');
    }

    /**
     * Show the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Set  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Set $set)
    {
        $viewData = $this->prepareViewData($set);

        $set->load(['setSubscriptions', 'setSubscriptions.user', 'setSubscriptions.bandRoles']);

        return $request->wantsJson() ? response()->json($viewData) : view('sets.show', $viewData);
    }

    /**
     * Edit the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Set  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Set $set)
    {
        $viewData = $this->prepareViewData($set);

        return $request->wantsJson() ? response()->json($viewData) : view('sets.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Set $set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Set $set)
    {
        $this->validate($request, $this->validationRules);

        $success = $set->update($this->transformInput($request));

        return redirect()->route('sets.view', ['set' => $set]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Set $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Set $set)
    {
        if ($set->delete()) {
            $request->session()->flash('alert-success', trans('sets.deleted_successfully'));    
        } else {
            $request->session()->flash('alert-failure', trans('sets.delete_failed'));    
        }

        return redirect()->route('sets.index');
    }

    /**
     * Transforms input data for creating/updating sets
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     **/
    private function transformInput(Request $request)
    {
        $data = $request->intersect(['title', 'when', 'service_id', 'description']);

        $data['when'] = app('date_helper')->getFromInputString($data['when']);

        return $data;
    }

    /**
     * Get all songs for this set as json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Set  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function songs(Request $request, Set $set)
    {
        $songs = $set->setSongs->load(['song', 'song.authors']);
        
        return response()->json(['songs' => $songs]);
    }

    /**
     * Edit the set members
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Set  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request, Set $set)
    {
        $users = User::orderBy('last_name')->orderBy('first_name')->get(['id', 'first_name', 'last_name']);
        $bands = Band::orderBy('title')->get();
        $bandRoles = BandRole::orderBy('title')->get();

        $set->load([
            'setSubscriptions',
            'setSubscriptions.user', 
            'setSubscriptions.bandRoles',
        ]);

        $bands->load([
            'bandSubscriptions',
            'bandSubscriptions.bandRoles',
        ]);

        return view('sets.members', compact('set', 'users', 'bands', 'bandRoles'));
    }

    /**
     * Helper method to prepare view data for show and edit
     *
     * @param  \App\Set  $set
     * @return array
     **/
    private function prepareViewData(Set $set) : array
    {
        $set->load('service')
            ->setSongs
            ->load(['song', 'song.authors']);

        return compact('set');
    }
}

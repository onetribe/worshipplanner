<?php

namespace App\Http\Controllers;

use App\Set;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SetsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
        Set::create($this->transformInput($request));

        return redirect()->route('sets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Set  $set
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Set $set)
    {
        //eager load relations
        $set->load('service')
            ->setSongs
            ->load(['song', 'song.authors']);

        $viewData = compact('set');

        return $request->wantsJson() ? response()->json($viewData) : view('sets.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}

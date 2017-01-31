<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;

class SongsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Displays all songs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::orderBy('title', 'ASC')->get();

        return view('songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new song.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created song in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Song::create($this->transformInput($request));

        return redirect()->route('songs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\SOng  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Song $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Song $song)
    {
        if ($song->delete()) {
            $request->session()->flash('alert-success', trans('songs.deleted_successfully'));    
        } else {
            $request->session()->flash('alert-failure', trans('songs.delete_failed'));    
        }

        return redirect()->route('songs.index');
    }

    /**
     * Transforms input data for creating/updating songs
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     **/
    private function transformInput(Request $request)
    {
//        $data = $request->only(['title', 'when', 'service_id', 'description']);
//
//        $data['when'] = app('date_helper')->getFromInputString($data['when']);
//
//        return $data;
    }
}

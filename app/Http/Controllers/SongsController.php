<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    use FlashesSuccessAndFailureTrait;

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
        $song = Song::create($this->transformInput($request));

        return redirect()->route('songs.edit', ['song' => $song]);
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

        return view('songs.edit', compact('song'));
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
        $success = $song->update($this->transformInput($request));

        $this->flashUpdate($request, $success);

        return redirect()->route('songs.edit', ['song' => $song]);
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
        $data = $request->only([
            'title',
            'alternative_title',
            'lyrics',
            'copyrights',
            'ccli',
            'default_key',
            'default_tempo',
            'youtube',
        ]);

        return $data;
    }
}

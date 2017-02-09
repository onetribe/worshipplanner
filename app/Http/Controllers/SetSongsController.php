<?php

namespace App\Http\Controllers;

use App\Repositories\SetSongRepository;
use App\Set;
use App\SetSong;
use Illuminate\Http\Request;

class SetSongsController extends Controller
{
    use FlashesSuccessAndFailureTrait;

    /**
     * @var array
     **/
    protected $validationRules = [];

    /**
     * @var App\Repositories\SetSongRepository
     **/
    protected $setSongRepo;

    public function __construct(SetSongRepository $setSongRepo)
    {
        $this->middleware('auth');
        $this->validationRules = $setSongRepo->getModel()->getValidationRules();

        $this->setSongRepo = $setSongRepo;
    }


    /**
     * Store a newly created setSong in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        $setSong = SetSong::create($this->transformInput($request));

        return response()->json(['setSong' => $setSong]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SetSong  $setSong
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SetSong $setSong)
    {
        $this->validate($request, $this->validationRules);

        $success = $setSong->update($this->transformInput($request));

        return response()->json(['setSong' => $setSong]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SetSong $setSong
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SetSong $setSong)
    {
        if ($setSong->delete()) {
            response()->json(['message' => trans('songs.deleted_successfully')]);
        } else {
            response()->json(['message' => trans('songs.deleted_successfully')]);
        }
    }


    /**
     * Orders the songs passed via the POST body
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Set $set
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request, Set $set)
    {
        $setSongs = $request->get('songs');

        foreach ($setSongs as $position => $setSong) {
            if ($setSong = $this->setSongRepo->find($setSong['id'])) {
                $setSong->update(['position' => $position]);
            }
        }

        return response()->json([]);
    }

    /**
     * Transforms input data for creating/updating songs
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return array
     **/
    private function transformInput(Request $request)
    {
        $data = $request->intersect([
            'set_id',
            'song_id',
            'position',
            'song_key',
            'song_tempo',
            'song_lyrics',
        ]);

        return $data;
    }
}

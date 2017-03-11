<?php

namespace App\Http\Controllers;

use App\Set;
use App\Song;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use ZipArchive;

class ExportsController extends Controller
{

    /**
     * @return void
     **/
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Export a set to an OpenSong xml file
     *
     * @param Illuminate\Http\Request $request
     * @param App\Set $set
     * @return \Illuminate\Http\Response
     */
    public function openSongSet(Request $request, Set $set)
    {
        $set->load('songs');

        //strip non ascii characters
        $filename = str_replace(" ", "_", $set->title);
        $filename = preg_replace("/[^a-zA-Z0-9\-\_]+/u", '', $filename);

        return response()
            ->view('export.set', compact('set'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename=' . $filename);
    }

    /**
     * Export songs to a zip file of OpenSong xml files
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function openSongSongs(Request $request)
    {
        $songs = Song::whereIn('id', $request->get('song_ids'))->with(['authors'])->get();

        $file = tempnam("tmp", "zip"); 
        $zip = new ZipArchive;
        $zip->open($file, ZipArchive::CREATE);
        foreach ($songs as $song) {
            $songFileContents = view('export.songs', ['song' => $song]);
            $zip->addFromString($song->full_title, $songFileContents);
        }

        $zip->close();

        return response(file_get_contents($file))
            ->header('Content-Type', 'application/zip')
            ->header('Content-Disposition', 'attachment; filename=songs.zip');
    }
}
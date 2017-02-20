<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Services\Transposer;
use App\Song;
use Illuminate\Auth\AuthManager;

class SongObserver
{
    use SetsActiveTeamOnCreateTrait;
    use StripsTagsFromFields;

    /**
     * @var App\Services\Transposer
     **/
    protected $transposer;

    /**
     * @var Illuminate\Auth\AuthManager
     **/
    protected $auth;

    /**
     * @param App\Services\ActiveTeam $activeTeam
     * @param App\Services\Transposer $transposer
     * @param Illuminate\Auth\AuthManager $auth
     * @return void
     **/
    public function __construct(
        ActiveTeam $activeTeam, 
        Transposer $transposer,
        AuthManager $auth
    )
    {
        $this->activeTeam = $activeTeam;
        $this->transposer = $transposer;
        $this->auth = $auth;
    }

    /**
     * Listen to the Song saving event.
     *
     * @param Song $song
     * @return bool
     */
    public function saving(Song $song)
    {
        if (is_null($song->lyrics)) {
            $song->lyrics = "";
        }

        $song->lyrics = str_replace("\r\n", "\n", $song->lyrics);
        $song->lyrics = $this->transposer->replaceSharpsAndFlatsInSong($song->lyrics);

        $this->stripTags($song, ['lyrics', 'youtube', 'copyrights', 'title', 'alternative_title']);

        return true;
    }

    /**
     * Listen to the Song creating event.
     *
     * @param Song $song
     * @return bool|null
     */
    public function creating(Song $song)
    {
        $song->creator_id = $this->auth->user()->id;

        return $this->setTeamOnCreating($song);
    }

}
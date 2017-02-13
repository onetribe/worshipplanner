<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Services\Transposer;
use App\Song;

class SongObserver
{
    use SetsActiveTeamOnCreateTrait;
    use StripsTagsFromFields;

    /**
     * @var App\Services\Transposer
     **/
    protected $transposer;

    /**
     * @param ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam, Transposer $transposer)
    {
        $this->activeTeam = $activeTeam;
        $this->transposer = $transposer;
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
        return $this->setTeamOnCreating($song);
    }

}
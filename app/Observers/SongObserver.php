<?php

namespace App\Observers;

use App\Services\ActiveTeam;
use App\Song;

class SongObserver
{
    use SetsActiveTeamOnCreateTrait;
    use StripsTagsFromFields;

    /**
     * @param DateHelperInterface $dateHelper
     * @param ActiveTeam $activeTeam
     * @return void
     **/
    public function __construct(ActiveTeam $activeTeam)
    {
        $this->activeTeam = $activeTeam;
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
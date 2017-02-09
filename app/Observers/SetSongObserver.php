<?php

namespace App\Observers;

use App\Repositories\SetSongRepository;
use App\SetSong;

class SetSongObserver
{
    use StripsTagsFromFields;

    /**
     * @param SetSongRepository $setSongRepo
     *
     * @return void
     **/
    public function __construct(SetSongRepository $setSongRepo)
    {
        $this->setSongRepo = $setSongRepo;
    }

    /**
     * Listen to the SetSong saving event.
     *
     * @param SetSong $setSong
     *
     * @return bool
     */
    public function saving(SetSong $setSong)
    {
        $this->stripTags($setSong, ['song_lyrics']);

        return true;
    }

    /**
     * Listen to the SetSong creating event.
     *
     * @param SetSong $setSong
     *
     * @return bool|null
     */
    public function creating(SetSong $setSong)
    {
        $setSongs = $this->setSongRepo
            ->where('set_id', $setSong->set_id)
            ->orderBy('position', 'ASC')
            ->get();

        //set position of new setong one higher then the last song in the set
        $newPosition = $setSongs->last() ? $setSongs->last()->position + 1 : 0;

        $setSong->position = $newPosition;
    }

}
<?php

namespace App\Observers;

use App\Repositories\SetSongRepository;
use App\Services\Transposer;
use App\SetSong;

class SetSongObserver
{
    use StripsTagsFromFields;

    /**
     * @var SetSongRepository
     **/
    protected $setSongRepo;

    /**
     * @var Transposer
     **/
    protected $transposer;

    /**
     * @param SetSongRepository $setSongRepo
     * @param Transposer $transposer
     *
     * @return void
     **/
    public function __construct(SetSongRepository $setSongRepo, Transposer $transposer)
    {
        $this->setSongRepo = $setSongRepo;
        $this->transposer = $transposer;
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

        $setSong->song_lyrics = str_replace("\r\n", "\n", $setSong->song_lyrics);
        $setSong->song_lyrics = $this->transposer->replaceSharpsAndFlatsInSong($setSong->song_lyrics);

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
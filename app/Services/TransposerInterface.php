<?php

namespace App\Services;

interface TransposerInterface
{
	/**
     * Transposes the given song's lyrics. Returns the lyrics as a string
     *
     * @param App\Song | App\SetSong $song. Either pass a Song or a setSong
     * @param string $key
     * @return string
     **/
    public function transposeSong($song, $key): string;

    /**
     * Transpose the given song to the given Key
     *
     * @param string $song
     * @param string $toKey
     * @param string $originalKey
     * @return string
     **/
    public function transpose($song, $toKey, $originalKey): string;

     /**
     * Identifies what the difference in semi-tones the two different keys are
     *
     * @param string $toKey
     * @param string $originalKey
     * @return int
     **/
    public function identifyKeyDifference($toKey, $originalKey): int;

    /**
     * Check if given line contains chords
     *
     * @param string $line
     * @return bool
     **/
    public function isChordLine($line): bool;
}

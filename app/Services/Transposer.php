<?php

namespace App\Services;

class Transposer implements TransposerInterface
{
    /**
     * @var ScaleService
     **/
    protected $scaleService;

    /**
     * @param ScaleService $scaleService
     * @return void
     **/
    public function __construct(ScaleService $scaleService)
    {
        $this->scaleService = $scaleService;
    }

    /**
     * Transposes the given song's lyrics. Returns the lyrics as a string
     *
     * @param App\Song | App\SetSong $song. Either pass a Song or a setSong
     * @param string $key
     * @return string
     **/
    public function transposeSong($song, $key): string
    {
        $originalKey = $song->key;
        //TO DO:
        //if no original key found, try and find out from lyrics.
        
        $lyrics = $song->lyrics;

        return $this->transpose($lyrics, $key, $originalKey);
    }

    /**
     * Transpose the given song to the given Key
     *
     * @param string $lyrics
     * @param string $toKey
     * @param string $originalKey
     * @return string
     **/
    public function transpose($lyrics, $toKey, $originalKey): string
    {
        $lines = explode("\n", $lyrics);

        $semiTonesDiff = $this->identifyKeyDifference($toKey, $originalKey);
        $useSharpsForKey = $this->scaleService->useSharpsForKey($toKey);

        $linesOut = [];
        
        foreach ($lines as $number => $line) {
            $chordReplacements = [];
            if (! $this->isChordLine($line)) {
                $linesOut[] = $line;
                continue;
            }

            $chordsInLine = $this->getChords($line);
            foreach ($chordsInLine as $chord) {
                //if given chord was not found, skip it
                if (! $originalChordNumber = $this->scaleService->whereInScaleIsKey($chord)) {
                    continue;
                }

                $toChordNumber = $originalChordNumber + $semiTonesDiff;
                if ($toChordNumber < 1) {
                    $toChordNumber = $toChordNumber + 12;
                }
                if ($toChordNumber > 12) {
                    $toChordNumber = $toChordNumber - 12;
                }

                $chordReplacements[$chord] = $this->scaleService->getNoteAtNumber($toChordNumber, $useSharpsForKey);
            }

            $linesOut[] = str_replace(array_keys($chordReplacements), array_values($chordReplacements), $line);
        }

        return implode("\n", $linesOut);
    }

    /**
     * Identifies what the difference in semi-tones the two different keys are
     *
     * @param string $toKey
     * @param string $originalKey
     * @return int
     **/
    public function identifyKeyDifference($toKey, $originalKey): int
    {
        $toKey = $this->scaleService->replaceSharpsAndFlats($toKey);
        $originalKey = $this->scaleService->replaceSharpsAndFlats($originalKey);;
    
        $number1 = $this->scaleService->whereInScaleIsKey($originalKey);
        $number2 = $this->scaleService->whereInScaleIsKey($toKey);

        return (int) $number2 - $number1;
    }

    /**
     * Check if given line contains chords
     *
     * @param string $line
     * @return bool
     **/
    public function isChordLine($line): bool
    {
        return strlen($line) > 0 ? substr_compare(trim($line), ".", 0, 1) === 0 : false;
    }

    /**
     * Returns all the chords within a line
     *
     * @param string $line
     * @return array
     **/
    protected function getChords($line): array
    {
        $line = str_replace(['/', '(', ')'], ' ', $line);
        $line = preg_replace(['/[0-9]/', '/sus|maj|dim|aug|m|\.|\+/'], '', $line);
        $line = preg_replace(['/\s+/', ], ' ', $line);

        return explode(" ", $line);
    }

}
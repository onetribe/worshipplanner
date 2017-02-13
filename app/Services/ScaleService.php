<?php

namespace App\Services;

class ScaleService
{
    /**
     * @var array
     **/
    protected $defaultKeys = ['A', 'B♭', 'B', 'C', 'D♭', 'D', 'E♭', 'E', 'F', 'F♯', 'G', 'A♭'];

    /**
     * @var array
     **/
    protected $majorScaleDistances = [2, 2, 1, 2, 2, 2, 1];

    /**
     * Returns a major scale for the given key
     *
     * @param string
     * @return array
     **/
    public function getMajorScale($key): array
    {
        $key = $this->replaceSharpsAndFlats($key);
        $position = $this->whereInScaleIsKey($key);

        $scale = [$key];
        foreach ($this->majorScaleDistances as $distance) {
            $position = $position + $distance;
            if ($position > 12) {
                $position = $position - 12;
            }
            $scale[] =  $this->getNoteAtNumber($position, $this->useSharpsForKey($key));
        }

        return $scale;
    }

    /**
     * Returns the note at the given number
     *
     * @param int $number
     * @param bool $useSharps
     * @return string
     **/
    public function getNoteAtNumber($number, $useSharps): string
    {
        $scale = $this->getFullScale();
        $note = isset($scale[$number]) ? $scale[$number] : "";

        return is_array($note) ? ($useSharps ? $note['♯'] : $note['♭']) : $note;
    }

    /**
     * Returns a scale as an array
     *
     * @return array
     **/
    protected function getFullScale(): array
    {
        return [
            1 => 'A',
            2 => ['♯' => 'A♯', '♭' => 'B♭'],
            3 => 'B',
            4 => 'C',
            5 => ['♯' => 'C♯', '♭' => 'D♭'],
            6 => 'D',
            7 => ['♯' => 'D♯', '♭' => 'E♭'],
            8 => 'E',
            9 => 'F',
            10 => ['♯' => 'F♯', '♭' => 'G♭'],
            11 => 'G',
            12 => ['♯' => 'G♯', '♭' => 'A♭'],
        ];
    }

    /**
     * Semi-tone differences between notes in a major scale
     *
     * @return array
     **/
    public function getMajorScaleDistances(): array
    {
        return $this->majorScaleDistances;
    }

    /**
     * Identify where in the scale the given key is.
     *
     * @param string $key
     * @return int
     **/
    public function whereInScaleIsKey($key): int
    {
        $scale = [
            'A' => 1,
            'A♯' => 2,
            'B♭' => 2,
            'B' => 3,
            'C' => 4,
            'C♯' => 5,
            'D♭' => 5,
            'D' => 6,
            'D♯' => 7,
            'E♭' => 7,
            'E' => 8,
            'F' => 9,
            'F♯' => 10,
            'G♭' => 10,
            'G' => 11,
            'G♯' => 12,
            'A♭' => 12,
        ];

        return isset($scale[$key]) ? (int) $scale[$key] : 0;
    }

    /**
     * Determines whether the given key uses sharps or flats. Returns true if sharps, false if flats
     *
     * @param string $key
     * @return bool
     **/
    public function useSharpsForKey($key): bool
    {
        $key = $this->replaceSharpsAndFlats($key);

        switch ($key) {
            case 'A':
            case 'A♯':
            case 'C':
            case 'C♯':
            case 'D':
            case 'D♯':
            case 'E':
            case 'F♯':
            case 'G':
            case 'G♯':
            default:
                return true;
                break;
            case 'B♭':
            case 'B':
            case 'D♭':
            case 'E♭':
            case 'F':
            case 'G♭':
            case 'A♭':
                return false;
                break;
        }
    }

    /**
     * Helper method to replace # and b signs with ♭ and ♯
     *
     * @param string $str
     * @return string
     **/
    public function replaceSharpsAndFlats($str): string
    {
        return str_replace(["b", "#"], ["♭", "♯"], $str);
    }

    /**
     * Returns all the default keys that are used on the site
     *
     * @return array
     **/
    public function getDefaultKeys(): array
    {
        return $this->defaultKeys;
    }
}
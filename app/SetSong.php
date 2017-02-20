<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetSong extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'song_id',
        'set_id',
        'position',
        'song_key',
        'song_tempo',
        'song_lyrics',
    ];

    /**
     * @var array
     **/
    protected $defaultValidationRules = [
        'song_lyrics' => 'max:5000',
        'song_tempo' => 'integer|max:300|nullable',
        'song_key' => 'max:4',
        'position' => 'integer|nullable',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['either_key', 'either_tempo'];

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     * Get the original song for this setSong
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
   
    /**
     * Get the set for this setSong
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Accessors
    |--------------------------------------------------------------------------
    */
   
    /**
     * Get the setSong lyrics.. if it doesn't have lyrics, use the setSong original song's lyrics
     *
     * @return string
     */
    public function getEitherLyricsAttribute()
    {
        return $this->song_lyrics ? $this->song_lyrics : $this->song->lyrics;
    }

    /**
     * Get the setSong key.. if it doesn't have a key, use the setSong original song's key
     *
     * @return string
     */
    public function getEitherKeyAttribute()
    {
        return $this->song_key ? $this->song_key : $this->song->default_key;
    }

    /**
     * Get the setSong key.. if it doesn't have a key, use the setSong original song's key
     *
     * @return string
     */
    public function getEitherTempoAttribute()
    {
        return $this->song_tempo ? $this->song_tempo : $this->song->default_tempo;
    }   

    /**
     * Just an alias for getEitherLyricsAttribute
     *
     * @return string
     */
    public function getLyricsAttribute()
    {
        return $this->getEitherLyricsAttribute();
    }

    /**
     * Just an alias for getEitherKeyAttribute
     *
     * @return string
     */
    public function getKeyAttribute()
    {
        return $this->getEitherKeyAttribute();
    }

    /**
     * Just an alias for getEitherTempoAttribute
     *
     * @return string
     */
    public function getTempoAttribute()
    {
        return $this->getEitherTempoAttribute();
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
    
    /**
    * Returns the default validation rules for a setsong
    *
    * @return array
    **/
   public function getValidationRules()
   {
        return $this->defaultValidationRules;
   }
}

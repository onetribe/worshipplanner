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

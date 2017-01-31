<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	use TeamDependentModelTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'alternative_title', 
        'copyrights', 
        'ccli', 
        'default_key', 
        'default_tempo',
        'lyrics',
    ];


    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     * Get all sets this song belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sets()
    {
        return $this->belongsToMany(Set::class, "set_songs");
    }

    /**
     * Get all the ways this song is used in different sets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setSongs()
    {
        return $this->hasMany(SetSong::class);
    }

    /**
     * Get all authors that wrote this song
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'song_author');
    }

    /**
     * Get all tags for this song
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	use TeamDependentModelTrait, HasCreatorTrait, ApiScopesTrait, HasValidationRulesTrait;

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
        'youtube',
        'default_time_signature',
        'creator_id',
    ];

    /**
     * @var array
     **/
    protected $defaultValidationRules = [
        'title' => 'required|max:255',
        'alternative_title' => 'max:255',
        'lyrics' => 'max:5000',
        'ccli' => 'integer|nullable',
        'default_tempo' => 'integer|max:300|nullable',
        'default_key' => 'max:4',
        'youtube' => 'max:255',
        'default_time_signature' => 'max:5',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_title', 'author_list'];


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

    /*
    |--------------------------------------------------------------------------
    | Model Attributes Accessors
    |--------------------------------------------------------------------------
    */
   
    /**
     * Shows the title and the alternative title
     *
     * @return string
     **/
    public function getFullTitleAttribute()
    {
        return $this->title . ($this->alternative_title ? " (" . $this->alternative_title . ")" : "");
    }

    /**
     * Returns a list of the authors' names, comma separated
     *
     * @return string
     **/
    public function getAuthorListAttribute()
    {
        return $this->authors->implode('name', ', ');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

}

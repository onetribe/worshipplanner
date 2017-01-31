<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	use TeamDependentModelTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
    ];


    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get all songs written by this author
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    /**
     * Name accessor
     *
     * @return string
     **/
    public function getNameAttribute()
    {
        return $this->first_name . " " . ($this->middle_name ? $this->middle_name . " " : "" ) . $this->last_name;
    }
}

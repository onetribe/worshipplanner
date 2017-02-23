<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use ApiScopesTrait;

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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];


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
     * Get the team that owns this author.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    
    /*
    |--------------------------------------------------------------------------
    | API order
    |--------------------------------------------------------------------------
    */
    /**
     * Ordering for the API query
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     **/
    public function addDefaultOrderBy($query)
    {
        $query->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('middle_name', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
   
    /**
     * Name accessor
     *
     * @return string
     **/
    public function getNameAttribute()
    {
        return $this->first_name . " " . ($this->middle_name ? $this->middle_name . " " : "" ) . $this->last_name;
    }


    /**
     * Check whether this is a shared author between all teams
     *
     * @return bool
     **/
    public function isShared()
    {
        return is_null($this->team_id);
    }
}

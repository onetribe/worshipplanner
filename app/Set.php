<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use TeamDependentModelTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'when',
        'description',
        'service_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'when'
    ];


    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get all original songs that are used in this set.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, "set_songs");
    }

    /**
     * Get all setSongs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setSongs()
    {
        return $this->hasMany(SetSong::class)->orderBy('position', 'ASC');
    }

    /**
     * Get the service for this set
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}

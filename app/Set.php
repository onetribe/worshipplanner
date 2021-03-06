<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use TeamDependentModelTrait, HasCreatorTrait, HasValidationRulesTrait;

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

    /**
     * @var array
     **/
    protected $defaultValidationRules = [
        'title' => 'max:255',
        'description' => 'max:2000',
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

    /**
     * Get all setSubscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setSubscriptions()
    {
        return $this->hasMany(SetSubscription::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
    
}

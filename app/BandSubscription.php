<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandSubscription extends Model
{
    /**
     * 
     *
     * @var string
     **/
    protected $fillable = ['band_id', 'user_id'];

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function band()
    {
        return $this->belongsTo(Band::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the roles for the user has for this band subscriptions. 
     * ie. what intstruments/roles do they usually play for this band.
     * This is used for populating set band roles when adding users to sets by band
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function bandRoles()
    {
        return $this->morphToMany(BandRole::class, 'has_band_role', 'has_band_roles', 'has_band_role_id', 'band_role_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
}

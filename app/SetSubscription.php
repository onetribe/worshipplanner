<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetSubscription extends Model
{
    /**
     * 
     *
     * @var string
     **/
    protected $fillable = ['set_id', 'user_id'];

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function set()
    {
        return $this->belongsTo(Set::class);
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
     * Get all of the roles for the user has for this set subscriptions. ie. what intstruments/roles do they play for this set
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

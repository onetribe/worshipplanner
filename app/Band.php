<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use TeamDependentModelTrait, ApiScopesTrait, HasValidationRulesTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @var array
     **/
    protected $defaultValidationRules = [
        'title' => 'required|max:255',
    ];


    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bandSubscriptions()
    {
        return $this->hasMany(BandSubscription::class);
    }

    /**
     * Get all users associated with this band
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'band_subscriptions');
    }
}

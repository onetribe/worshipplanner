<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use TeamDependentModelTrait, ApiScopesTrait;

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
     * Get all sets associated with this service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sets()
    {
        return $this->hasMany(Set::class);
    }

}

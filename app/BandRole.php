<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandRole extends Model
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

}

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

}

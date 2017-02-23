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
        $query->orderBy('title', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

}

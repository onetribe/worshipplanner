<?php

namespace App;

trait ApiScopesTrait
{

    /**
     * Can be implemented by extending repository to set the default ordering
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     **/
    public function addDefaultOrderBy($query)
    {
    }

    /**
     * Get multiple models for api requests
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array $ids    
     * @param  int|null $page   
     * @param  int $perPage
     * @return \Illuminate\Database\Eloquent\Builder            
     */
    public function scopeMultiForApi(
        $query,
        array $ids = ['*'],
        int $page = null,
        int $perPage = 50
    )
    {
        if (head($ids) !== '*') {
            $query->whereIn($this->getKeyName(), $ids);
        }

        if (! is_null($page)) {
            $query->forPage($page, $perPage);
        }

        $this->addDefaultOrderBy($query);

        return $query;
    }
}

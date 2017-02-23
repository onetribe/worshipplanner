<?php

namespace App\Transformers;

class BandSubscriptionTransformer extends AbstractTransformer
{
    /**
     * @var array
     **/
    protected $availableIncludes = ['user', 'bandRoles'];

    /**
     * Include User
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeUser($model)
    {
        return $this->item($model->user, new UserTransformer);
    }

    /**
     * Include Band Roles
     *
     * @return League\Fractal\Resource\Collection
     */
    public function includeBandRoles($model)
    {
        return $this->collection($model->bandRoles, new BandRoleTransformer);
    }
}
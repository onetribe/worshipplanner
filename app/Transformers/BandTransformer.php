<?php

namespace App\Transformers;

class BandTransformer extends AbstractTransformer
{
    /**
     * @var array
     **/
    protected $availableIncludes = ['bandSubscriptions'];


    /**
     * Include BandSubscriptions
     *
     * @return League\Fractal\Resource\Collection
     */
    public function includeBandSubscriptions($model)
    {

        return $this->collection($model->bandSubscriptions, new BandSubscriptionTransformer);
    }
}
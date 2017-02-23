<?php

namespace App\Transformers;

use App\Transformers\UserTransformer;

class TeamSubscriptionTransformer extends AbstractTransformer
{
    /**
     * @var array
     **/
    protected $availableIncludes = ['user'];

    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    public function transform($model)
    {
        return array_merge([
            'id' => (int) $model->id,
            'team_id' => (int) $model->team_id,
            'user_id' => (int) $model->user_id,
            'role' => (string) $model->roleName(),
        ], $this->transformTimestamps($model));
    }

    /**
     * Include User
     *
     * @return League\Fractal\ItemResource
     */
    public function includeUser($model)
    {

        return $this->item($model->user, new UserTransformer);
    }
}
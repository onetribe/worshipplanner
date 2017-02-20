<?php

namespace App\Transformers;

class TeamSubscriptionTransformer extends AbstractTransformer
{
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
            'role' => (int) $model->roleName(),
        ], $this->transformTimestamps($model));
    }

}
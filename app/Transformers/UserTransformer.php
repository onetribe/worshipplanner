<?php

namespace App\Transformers;

class UserTransformer extends AbstractTransformer
{
    /**
     * The default transform just does a basic transform of id, title and timestamps
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    public function transform($model)
    {
        return array_merge([
            'id' => (int) $model->id,
            'first_name' => (string) $model->first_name,
            'last_name' => (string) $model->last_name,
            'email' => (string) $model->email,
            'timezone' => (string) $model->timezone,
        ], $this->transformTimestamps($model));
    }

}
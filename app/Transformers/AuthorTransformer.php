<?php

namespace App\Transformers;

class AuthorTransformer extends AbstractTransformer
{
    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    public function transform($model)
    {
        $timeStamps = is_null($model->team_id) ? [] : $this->transformTimestamps($model);
        
        return array_merge([
            'id' => (int) $model->id,
            'first_name' => (string) $model->first_name,
            'middle_name' => (string) $model->middle_name,
            'last_name' => (string) $model->last_name,
            'name' => (string) $model->name,
            'is_default' => (bool) is_null($model->team_id),
        ], $timeStamps);
    }

}
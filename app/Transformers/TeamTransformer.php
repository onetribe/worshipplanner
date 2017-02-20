<?php

namespace App\Transformers;

class TeamTransformer extends AbstractTransformer
{
    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    public function transform($model)
    {
        return array_merge($this->transformBasics($model), [
            'country_code' => (string) $model->country_code,
        ]);
    }

}
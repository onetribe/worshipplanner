<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class AbstractTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * The default transform just does a basic transform of id, title and timestamps
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    public function transform($model)
    {
        return $this->transformBasics($model);
    }

    /**
     * A basic transform of id, title and timestamps
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return array
     **/
    public function transformBasics($model) : array
    {
        return array_merge(
            $this->transformIdTitle($model), 
            $this->transformTimestamps($model)
        );
    }

    /**
     * Transform ID and title attributes
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return array
     **/
    protected function transformIdTitle($model)
    {
        return [
            'id' => (int) $model->id,
            'title' => (string) $model->title,
        ];
    }

    /**
     * Helper method to transform created_at and updated_timestamps
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return array
     **/
    public function transformTimestamps($model) : array
    {
        return [
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];
    }
}
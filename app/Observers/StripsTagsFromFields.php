<?php

namespace App\Observers;

trait StripsTagsFromFields
{

    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @param array $fields
     *
     * @return void
     */
    public function stripTags($model, array $fields)
    {
        array_map(function($field) use ($model) {
            $model->{$field} = strip_tags($model->{$field});
        }, $fields);
    }

}
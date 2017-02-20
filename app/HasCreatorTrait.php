<?php

namespace App;

trait HasCreatorTrait
{

    /**
     * Get the user who created this model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}

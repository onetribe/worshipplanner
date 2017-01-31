<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	use TeamDependentModelTrait;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Get all songs that are tagged with this tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

}

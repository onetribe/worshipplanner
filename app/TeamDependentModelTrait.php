<?php

namespace App;

use App\Scopes\TeamScope;

trait TeamDependentModelTrait
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootTeamDependentModelTrait()
    {
        static::addGlobalScope(new TeamScope);
    }

     /**
     * Get the team that owns this model.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

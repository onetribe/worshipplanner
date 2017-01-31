<?php

namespace App;

use App\Services\ActiveTeam;
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

        static::creating(function ($model) {
        	$model->team_id = app(ActiveTeam::class)->get()->id;

        	return true;
        });
    }

     /**
     * Get the team that owns this model.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

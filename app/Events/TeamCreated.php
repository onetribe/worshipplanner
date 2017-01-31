<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TeamCreated
{
    use SerializesModels;

    /**
     * The newly created team
     *
     * @var App\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param  App\Team  $team
     * @return void
     */
    public function __construct($team)
    {
        $this->team = $team;
    }
}

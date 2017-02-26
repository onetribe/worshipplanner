<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InviteLink extends Model
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
     * Generate a new access token for the given
     *
     * @param string
     * @return void
     **/
    public function generateToken()
    {
        return Str::random(60);
    }

    /**
     * Check whether this link has expired
     *
     * @param Carbon\Carbon $date
     * @return bool
     **/
    public function hasExpired(Carbon $date = null) : bool
    {
        $date = $date ?? Carbon::now();

        return $this->created_at->addHours(config('auth.invite_links.expire')) < $date;
    }

}

<?php

namespace App;

use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'timezone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     * All teams this user is a part of
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, "team_subscriptions");
    }

    /**
     * All team subscriptions associated with this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamSubscriptions()
    {
        return $this->hasMany(TeamSubscription::class);
    }

    /**
     * The last team that the user had active
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastTeam()
    {
        return $this->belongsTo(Team::class, "last_team_id");
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
   
   /**
    * @return void
    **/
   protected static function boot()
    {
        parent::boot();

        User::observe(UserObserver::class);
    }

    /**
     * Checks if user is super admin
     *
     * @return boolean
     **/
    public function isSuperAdmin()
    {
        return $this->is_superadmin;
    }
}

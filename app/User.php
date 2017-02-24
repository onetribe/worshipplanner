<?php

namespace App;

use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, ApiScopesTrait;

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
        'password', 'remember_token', 'is_superadmin'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

   /**
     * Ordering for the API query
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     **/
    public function addDefaultOrderBy($query)
    {
        $query->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC');
    }

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

    /**
     * Get all of the band roles the user has. ie. what intstruments/roles do they play
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function bandRoles()
    {
        return $this->morphToMany(BandRole::class, 'has_band_role', 'has_band_roles', 'has_band_role_id', 'band_role_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
      
    /**
     * Name accessor
     *
     * @return string
     **/
    public function getNameAttribute()
    {
        return $this->first_name .  ($this->last_name ? " " . $this->last_name : "");
    }

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

    /**
     * Checks whether this user is admin for the given team
     *
     * @param int $teamId
     * @return bool
     **/
    public function isAdminForTeam($teamId)
    {
        foreach ($this->teamSubscriptions as $subscription) {
            if ($subscription->isAdmin() && $teamId == $subscription->team_id) {
                return true;
            }
        }

        return false;
    }
}

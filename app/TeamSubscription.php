<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSubscription extends Model
{
    use ApiScopesTrait;
    
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * 
     *
     * @var string
     **/
    protected $fillable = ['user_id', 'team_id', 'role'];

    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the team that owns this model.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes and Order
    |--------------------------------------------------------------------------
    */
    /**
     * Used by API scope to get the order
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     **/
    public function addDefaultOrderBy($query)
    {
        return $query->join('users as u', 'u.id', '=', 'team_subscriptions.user_id')
            ->orderBy('u.last_name', 'ASC')
            ->orderBy('u.first_name', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */
   
   /**
    * Check whether the user is admin in this team
    *
    * @return boolean
    **/
   public function isAdmin()
   {
        return $this->role == static::ROLE_ADMIN;
   }

   /**
    * Check whether the user is a normal user in this team
    *
    * @return boolean
    **/
   public function isUser()
   {
        return $this->role == static::ROLE_USER;
   }
   
   /**
    * Make the user an admin
    *
    * @return boolean
    **/
   public function makeAdmin()
   {
        return $this->role = static::ROLE_ADMIN;
   }

   /**
    * Make the user a user
    *
    * @return boolean
    **/
   public function makeUser()
   {
        return $this->role = static::ROLE_USER;
   }

   /**
    * Get the role name
    *
    * @return string
    **/
   public function roleName()
   {
        switch ((int) $this->role) {
            case static::ROLE_USER:
            default:
                return trans('security.user');    
                break;
            case static::ROLE_ADMIN:
                return trans('security.administrator');    
                break;
        }
   }

   /**
    * Returns the role id from the name
    *
    * @param string $name
    * @return int
    **/
   public function getRoleFromName($name) : int
   {
        switch (strtolower($name)) {
            case 'administrator':
                return static::ROLE_ADMIN;
                break;
            case 'user':
                return static::ROLE_USER;
                break;
        }

        return 0;
   }
}

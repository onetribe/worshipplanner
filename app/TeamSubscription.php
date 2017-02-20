<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSubscription extends Model
{
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
    * Get the role name
    *
    * @return string
    **/
   public function roleName()
   {
        switch ($this->role) {
            case static::ROLE_USER:
            default:
                return trans('security.user');    
                break;
            case static::ROLE_ADMIN:
                return trans('security.administrator');    
                break;
        }
         
   }
}

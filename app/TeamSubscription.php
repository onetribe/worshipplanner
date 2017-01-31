<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamSubscription extends Model
{
    use TeamDependentModelTrait;

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
}

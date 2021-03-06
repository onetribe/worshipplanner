<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasCreatorTrait, HasValidationRulesTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'country_code',
        'access_code',
        'creator_id',
    ];

    /**
     * @var array
     **/
    protected $hidden = [
        'access_code'
    ];


    /**
     * @var array
     **/
    protected $defaultValidationRules = [
        'title' => 'required|max:255',
        'country_code' => 'required|max:2',
    ];
    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */
   
    /**
     * Get all songs associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
   
    /**
     * Get all sets associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sets()
    {
        return $this->hasMany(Set::class);
    }
   
    /**
     * Get all authors associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authors()
    {
        return $this->hasMany(Author::class);
    }
   
    /**
     * Get all services associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
   
    /**
     * Get all tags associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
   
    /**
     * Get all users associated with this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_subscriptions');
    }
}

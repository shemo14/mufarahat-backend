<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @method where(string $string, int $int)
 * @method static create(array $array)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','code', 'lat', 'lang', 'avatar', 'role', 'checked','address','device_id','isNotify','type','city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}
	public function getJWTCustomClaims()
	{
		return [];
	}

    public function Role()
    {
        return $this->hasOne('App\Models\Role','id','role');
    }

    public function avatar()
    {
        return appPath() . '/images/users/' . $this->avatar;
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }


    public function dalegateInformation()
    {
        return $this->hasOne('App\Models\Delegate', 'user_id', 'id');
    }


    public function cartItems()
    {
        return $this->hasMany('App\Models\Cart', 'user_id', 'id');
    }


    public function Answers()
    {
        return $this->hasMany('App\Models\QuestionUser', 'user_id', 'id');
    }

    public function Percentages()
    {
        return $this->hasMany('App\Models\PercentageUser', 'user_id', 'id');
    }


}

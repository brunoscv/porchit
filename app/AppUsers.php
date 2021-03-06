<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AppUsers extends Authenticatable implements JWTSubject
{
    use Notifiable;
   
    /**
     * 
     * The attributes that are mass assignabble
     * @var array
    */

    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'phone', 'address', 'zipcode', 'device'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
    */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'zipcode' => $this->zipcode,
                'device' => $this->device
            ]
        ];
    }
}
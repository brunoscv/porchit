<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recycler extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'phone', 'address', 'zipcode'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

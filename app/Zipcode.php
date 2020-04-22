<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    protected $fillable = ['description','state_id','status'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'products';
}

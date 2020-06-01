<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;

class ProductsZipcode extends Model
{
    protected $fillable = ['products_id','state_id','zipcode'];
    protected $guarded = ['id', 'created_at', 'update_at'];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Products::class);
    }
}

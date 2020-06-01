<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
use App\PickupsProducts;

class Pickups extends Model
{
    public function pickups() : BelongsToMany
    {
        return $this->belongsToMany(PickupsProducts::class);
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Products::class);
    }
}

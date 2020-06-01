<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pickups;
use App\Products;

class PickupsProducts extends Model
{
    public function pickups() : BelongsToMany
    {
        return $this->belongsToMany(Pickups::class);
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Products::class);
    }
}

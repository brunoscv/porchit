<?php

namespace App;
use App\ProductsZipcode;
use App\Pickups;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function zipcode() : BelongsToMany
    {
        return $this->belongsToMany(ProductsZipcode::class);
    }

    // public function pickups() : BelongsToMany
    // {
    //     return $this->belongsToMany(Pickups::class);
    // }

    public function pickups() : BelongsToMany
    {
        return $this->belongsToMany(PickupsProducts::class);
    }
}

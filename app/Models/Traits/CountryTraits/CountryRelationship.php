<?php

namespace App\Models\Traits\CountryTraits;

use App\Models\Favorite;

trait CountryRelationship
{
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

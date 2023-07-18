<?php

namespace App\Models\Traits\LeagueTraits;

use App\Models\Favorite;
use App\Models\Season;

trait LeagueRelationship
{
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}

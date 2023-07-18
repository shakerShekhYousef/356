<?php

namespace App\Models\Traits\TeamTrait;

use App\Models\Country;
use App\Models\Favorite;
use App\Models\Player;

trait TeamRelationship
{
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}

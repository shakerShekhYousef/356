<?php

namespace App\Models\Traits\FavoriteTrait;

use App\Models\Country;
use App\Models\League;
use App\Models\Team;
use App\Models\User;

trait FavoriteRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

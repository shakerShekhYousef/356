<?php

namespace App\Models\Traits\FcmTokenTraits;

use App\Models\User;

trait FcmTokenRelationship
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models\Traits\UserSettingTraits;

use App\Models\User;

trait UserSettingRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

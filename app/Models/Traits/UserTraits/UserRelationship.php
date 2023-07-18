<?php

namespace App\Models\Traits\UserTraits;

use App\Models\FcmToken;
use App\Models\UserSetting;

trait UserRelationship
{
    public function fcmToken()
    {
        return $this->belongsTo(FcmToken::class);
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }
}

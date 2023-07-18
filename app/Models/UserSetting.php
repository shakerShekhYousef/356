<?php

namespace App\Models;

use App\Models\Traits\UserSettingTraits\UserSettingRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory,UserSettingRelationship;

    protected $guarded = [];

    protected $casts = [
        'night_mode_from' => 'datetime:H:i',
        'night_mode_to' => 'datetime:H:i',
    ];
}

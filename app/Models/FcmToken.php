<?php

namespace App\Models;

use App\Models\Traits\FcmTokenTraits\FcmTokenMethod;
use App\Models\Traits\FcmTokenTraits\FcmTokenRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    use HasFactory,FcmTokenMethod,FcmTokenRelationship;

    protected $guarded = [];
}

<?php

namespace App\Models;

use App\Models\Traits\CountryTraits\CountryRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory,CountryRelationship;

    protected $guarded = [];
}

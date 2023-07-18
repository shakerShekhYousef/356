<?php

namespace App\Models;

use App\Models\Traits\LeagueTraits\LeagueRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory,LeagueRelationship;

    protected $guarded = [];

    protected $table = 'leagues';
}

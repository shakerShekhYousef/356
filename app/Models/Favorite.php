<?php

namespace App\Models;

use App\Models\Traits\FavoriteTrait\FavoriteMethod;
use App\Models\Traits\FavoriteTrait\FavoriteRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory,FavoriteMethod,FavoriteRelationship;

    protected $guarded = [];
}

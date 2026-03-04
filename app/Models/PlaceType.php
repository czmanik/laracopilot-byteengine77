<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlaceType extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
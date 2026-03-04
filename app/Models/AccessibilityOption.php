<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AccessibilityOption extends Model
{
    protected $fillable = ['name', 'slug', 'icon'];

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'place_accessibility');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'bio', 'avatar', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
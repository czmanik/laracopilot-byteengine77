<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color', 'icon'];

    public function programSlots(): HasMany
    {
        return $this->hasMany(ProgramSlot::class);
    }
}
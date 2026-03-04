<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    protected $fillable = ['place_id', 'name', 'description', 'capacity', 'sort_order'];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function programSlots(): HasMany
    {
        return $this->hasMany(ProgramSlot::class)->orderBy('starts_at');
    }
}
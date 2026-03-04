<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'description',
        'date_from', 'date_to', 'is_paid', 'is_active', 'primary_color',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to'   => 'date',
        'is_paid'   => 'boolean',
        'is_active' => 'boolean',
    ];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'zizkovska_noc' => 'Žižkovská noc',
            'mezidvorky'    => 'Žižkovské mezidvorky',
            default         => $this->type,
        };
    }
}
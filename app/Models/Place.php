<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    protected $fillable = [
        'event_id', 'place_type_id', 'organizer_id',
        'name', 'slug', 'description', 'address', 'city',
        'lat', 'lng', 'website', 'facebook', 'instagram',
        'cover_image', 'photos', 'program_from', 'program_to',
        'status', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'photos'       => 'array',
        'program_from' => 'datetime',
        'program_to'   => 'datetime',
        'lat'          => 'float',
        'lng'          => 'float',
        'is_active'    => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function placeType(): BelongsTo
    {
        return $this->belongsTo(PlaceType::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class)->orderBy('sort_order');
    }

    public function programSlots(): HasMany
    {
        return $this->hasMany(ProgramSlot::class);
    }

    public function accessibilityOptions(): BelongsToMany
    {
        return $this->belongsToMany(AccessibilityOption::class, 'place_accessibility');
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'approved' => 'Schváleno',
            'rejected' => 'Zamítnuto',
            default    => 'Čeká na schválení',
        };
    }
}
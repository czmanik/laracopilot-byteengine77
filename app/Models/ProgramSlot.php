<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramSlot extends Model
{
    protected $fillable = [
        'stage_id', 'place_id', 'activity_category_id',
        'title', 'description', 'performer',
        'starts_at', 'ends_at', 'status', 'image', 'sort_order',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function activityCategory(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class);
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'published'  => 'Publikováno',
            'cancelled'  => 'Zrušeno',
            default      => 'Koncept',
        };
    }
}
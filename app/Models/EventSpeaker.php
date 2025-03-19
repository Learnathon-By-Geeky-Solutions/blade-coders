<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class EventSpeaker extends Model
{
    /** @use HasFactory<\Database\Factories\EventSpeakerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'about',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function profilePicture(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}

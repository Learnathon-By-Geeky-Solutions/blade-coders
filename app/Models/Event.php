<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    /** @use HasFactory<\Database\Factories\EventFactory> */
    protected $fillable = [
        'name',
        'short_brief',
        'price',
        'start_date',
        'end_date',
        'location',
        'button_text',
        'title',
        'about',
        'youtube_link',
        'agenda',
        'status',
        'service_id',
        'event_type_id',
        'meeting_link',
    ];

    protected function casts(): array
    {
        return [
            'agenda' => 'array',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function eventSpeakers(): BelongsToMany
    {
        return $this->belongsToMany(EventSpeaker::class);
    }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('featuredImage');
    }

    public function backgroundImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('backgroundImage');
    }
}

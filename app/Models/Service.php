<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    use HasFactory;

    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    protected $fillable = [
        'icon',
        'name',
        'short_brief',
        'price',
        'button_text',
        'button_link',
        'about',
        'title',
        'youtube_link',
        'status',
    ];

    protected function casts(): array
    {
        return [
            // 'price' => 'decimal',
        ];
    }

    public function icon(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('icon');
    }

    public function backgroundImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('backgroundImage');
    }

    public function abilitySupportImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('abilitySupportImage');
    }

    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(Benefit::class);
    }

    public function abilitySupports(): BelongsToMany
    {
        return $this->belongsToMany(AbilitySupport::class);
    }

    public function ourProcesses(): BelongsToMany
    {
        return $this->belongsToMany(OurProcess::class);
    }
}

<?php

namespace App\Models;

use AmdadulHaq\UniqueSlug\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'content',
        'status',
    ];

    protected function casts(): array
    {
        return [

        ];
    }

    public function getSlugSourceAttribute(): string
    {
        return 'title';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function banner(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}

<?php

namespace App\Models;

use App\traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Blog extends Model
{
    use CreatedUpdatedBy;

    protected $fillable = [
        'blog_category_id',
        'title',
        'subtitle',
        'sections',
        'reading_time',
        'status',
    ];

    public $autoFillFields = [
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
        ];
    }

    public function setReadingTimeAttribute()
    {
        $this->attributes['reading_time'] = $this->calculateReadingTime();
    }

    protected function calculateReadingTime(): int
    {
        if (empty($this->sections)) {
            return 0;
        }

        $totalWords = str_word_count($this->title);

        foreach ($this->sections as $section) {
            $totalWords += str_word_count($section['title']);

            // Sanitize the content by stripping HTML tags
            $content = strip_tags($section['content']);
            $totalWords += str_word_count($content);
        }

        return (int) ceil($totalWords / 200);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function banner(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('banner');
    }

    public function featureImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->whereType('featureImage');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->setReadingTimeAttribute();
        });

        static::updating(function ($blog) {
            $blog->setReadingTimeAttribute();
        });
    }
}

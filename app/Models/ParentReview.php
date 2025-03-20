<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ParentReview extends Model
{
    protected $fillable = [
        'parent_name',
        'parent_designation',
        'feedback',
        'rating',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    public function parentAvatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}

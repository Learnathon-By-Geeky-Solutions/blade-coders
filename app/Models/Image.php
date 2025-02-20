<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'size',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}

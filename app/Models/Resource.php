<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'type',
        'link',
        'is_active',
    ];

    protected function casts()
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    public function file()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'label',
        'is_active',
        'is_created',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_created' => 'boolean',
        ];
    }
}

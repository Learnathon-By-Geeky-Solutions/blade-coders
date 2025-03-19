<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    public static function contentLimit($content, $limit = 50): string
    {
        return Str::limit(strip_tags($content), $limit);
    }
}

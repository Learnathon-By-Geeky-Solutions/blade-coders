<?php

namespace App\Enums;

enum BlogStatus: string
{
    case DRAFT = 'Draft';
    case PUBLISH = 'Publish';
}

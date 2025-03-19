<?php

namespace App\Enums;

enum ServiceStatus: string
{
    case PUBLISHED = 'Published';

    case DRAFT = 'Draft';
}

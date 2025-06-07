<?php

declare(strict_types=1);

namespace App\Enum;

enum ToolboxStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case MAINTENANCE = 'maintenance';
    case ARCHIVED = 'archived';
}

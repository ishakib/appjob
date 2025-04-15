<?php

namespace App\Enums;

enum JobStatusEnum: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    case DRAFT = 2;

    /**
     * Get all statuses as an array.
     */
    public static function all(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
            self::DRAFT->value,
        ];
    }
}

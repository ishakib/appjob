<?php

namespace App\Enums;

enum JobStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DRAFT = 'draft';

    /**
     * Get all statuses as an array.
     */
    public static function all(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
            self::BANNED->value,
        ];
    }
}

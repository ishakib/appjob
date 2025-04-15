<?php

namespace App\Enums;

enum TenantStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BANNED = 'banned';

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

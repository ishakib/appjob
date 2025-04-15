<?php

namespace App\Enums;

enum ApplicationStatusEnum: int
{
    case REJECTED = 0;
    case PENDING = 1;
    case BANNED = 2;
    case IN_PROGRESS = 3;
    case HIRED = 4;
    case NEGOTIATION = 5;
    case HOLD = 6;
    case ANY = 7;

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

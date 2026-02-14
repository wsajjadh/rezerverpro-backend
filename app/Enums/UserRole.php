<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case MANAGER = 2;
    case BILLER = 3;
    case USER = 4;
    case NORMAL_CUSTOMER = 5;
    case PAID_CUSTOMER = 6;

    /**
     * Human-readable label (useful for UI)
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::BILLER => 'Biller',
            self::USER => 'User',
            self::NORMAL_CUSTOMER => 'Normal Customer',
            self::PAID_CUSTOMER => 'Paid Customer',
        };
    }

    /**
     * Return array for forms/selects
     */
    public static function options(): array
    {
        return array_column(
            self::cases(),
            'value',
            'value'
        );
    }
}

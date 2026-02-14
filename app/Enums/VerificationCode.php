<?php

namespace App\Enums;

enum VerificationCode: int
{
    case EMAIL = 1;
    case PHONE = 2;

    public function label(): string
    {
        return match ($this) {
            self::EMAIL => 'Email',
            self::PHONE => 'Phone',
        };
    }

    public static function options(): array
    {
        return array_column(
            self::cases(),
            'value',
            'value'
        );
    }
}

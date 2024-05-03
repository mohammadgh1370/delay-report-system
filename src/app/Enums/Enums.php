<?php

namespace App\Enums;

use BackedEnum;

trait Enums
{
    public static function values(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value')
            : array_column($cases, 'name');
    }

    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    public static function migrationComment(): string
    {
        return implode('', array_map(fn ($case) => "$case->value => $case->name; ", static::cases()));
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum SaleStatus: int
{
    case PENDING = 0;

    case ORDERED = 1;

    case COMPLETED = 2;

    case SHIPPED = 3;

    case RETURNED = 4;

    case CANCELED = '5';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function getName(): string
    {
        return __(Str::studly($this->name));
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function getLabel($value)
    {
        foreach (self::cases() as $case) {
            if ($case->getValue() === $value) {
                return $case->getName();
            }
        }

        return null;
    }
}


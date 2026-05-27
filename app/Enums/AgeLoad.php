<?php

declare(strict_types=1);

namespace App\Enums;

use App\Exceptions\InvalidAgeException;

enum AgeLoad
{
    case YoungAdult; // 18–30
    case Adult; // 31–40
    case MiddleAged; // 41–50
    case Senior; // 51–60
    case Elder; // 61–70

    public function load(): float
    {
        return match ($this) {
            self::YoungAdult => 0.6,
            self::Adult => 0.7,
            self::MiddleAged => 0.8,
            self::Senior => 0.9,
            self::Elder => 1.0,
        };
    }

    public static function fromAge(int $age): self
    {
        return match (true) {
            $age >= 18 && $age <= 30 => self::YoungAdult,
            $age >= 31 && $age <= 40 => self::Adult,
            $age >= 41 && $age <= 50 => self::MiddleAged,
            $age >= 51 && $age <= 60 => self::Senior,
            $age >= 61 && $age <= 70 => self::Elder,
            default => throw new InvalidAgeException($age),
        };
    }
}

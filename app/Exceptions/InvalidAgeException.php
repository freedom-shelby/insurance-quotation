<?php

declare(strict_types=1);

namespace App\Exceptions;

use InvalidArgumentException;

class InvalidAgeException extends InvalidArgumentException
{
    public function __construct(int $age)
    {
        parent::__construct("Age $age is outside the supported range of 18–70.");
    }
}

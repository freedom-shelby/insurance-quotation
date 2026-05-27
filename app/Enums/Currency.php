<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency: string
{
    case EUR = 'EUR';
    case GBP = 'GBP';
    case USD = 'USD';
}

<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\Currency;
use DateTimeImmutable;

final readonly class CreateQuotationDTO
{
    /**
     * @param list<int> $ages
     */
    public function __construct(
        public array             $ages,
        public DateTimeImmutable $startDate,
        public DateTimeImmutable $endDate,
        public Currency          $currency,
        public int               $userId,
    ) {}
}

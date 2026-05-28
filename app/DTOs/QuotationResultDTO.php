<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\Currency;
use DateTimeImmutable;

readonly class QuotationResultDTO
{
    public function __construct(
        public DateTimeImmutable $startDate,
        public DateTimeImmutable $endDate,
        public int $tripLength,
        public int $fixedRate,
        public Currency $currency,
        public array $results,
        public float $total,
    ) {
    }
}

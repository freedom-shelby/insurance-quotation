<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Currency;
use App\Models\Quotation;
use App\Repositories\QuotationRepository;
use DateTimeImmutable;

final class QuotationService
{
    public function __construct(
        private readonly QuotationCalculatorService $calculator,
        private readonly QuotationRepository        $repository,
    ) {}

    /** @param list<int> $ages */
    public function createQuotation(
        array             $ages,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        Currency          $currency,
        int               $userId,
    ): Quotation {
        $result = $this->calculator->calculate($ages, $startDate, $endDate, $currency);

        return $this->repository->store($result, $userId);
    }
}

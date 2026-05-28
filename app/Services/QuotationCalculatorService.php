<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\QuotationResultDTO;
use App\Enums\AgeLoad;
use App\Enums\Currency;
use DateTimeImmutable;

class QuotationCalculatorService
{
    private const int FIXED_RATE = 3;

    public function calculate(
        array $ages,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        Currency $currency,
    ): QuotationResultDTO {
        $tripLength = (int)$startDate->diff($endDate)->days + 1;
        $results = [];
        $grandTotal = 0.0;

        foreach ($ages as $age) {
            $ageLoad = AgeLoad::fromAge($age);
            $total = round(self::FIXED_RATE * $ageLoad->load() * $tripLength, 2);
            $results[] = ["age" => $age, "ageLoad" => $ageLoad->load(), "total" => $total];
            $grandTotal += $total;
        }

        return new QuotationResultDTO(
            startDate: $startDate,
            endDate: $endDate,
            tripLength: $tripLength,
            fixedRate: self::FIXED_RATE,
            currency: $currency,
            results: $results,
            total: round($grandTotal, 2),
        );
    }
}

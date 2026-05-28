<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\QuotationResultDTO;
use App\Models\Quotation;

final class QuotationRepository
{
    public function store(QuotationResultDTO $result, int $userId): Quotation
    {
        return Quotation::create([
            "user_id"       => $userId,
            "age"           => array_column($result->results, "age"),
            "start_date"    => $result->startDate->format("Y-m-d"),
            "end_date"      => $result->endDate->format("Y-m-d"),
            "trip_length"   => $result->tripLength,
            "fixed_rate"    => $result->fixedRate,
            "age_load"      => array_column($result->results, "ageLoad"),
            "currency_code" => $result->currency->value,
            "total"         => $result->total,
        ]);
    }
}

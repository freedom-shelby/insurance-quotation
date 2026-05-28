<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CreateQuotationDTO;
use App\Models\Quotation;
use App\Repositories\QuotationRepository;

final class QuotationService
{
    public function __construct(
        private readonly QuotationCalculatorService $calculator,
        private readonly QuotationRepository        $repository,
    ) {}

    public function createQuotation(CreateQuotationDTO $dto): Quotation
    {
        $result = $this->calculator->calculate(
            $dto->ages,
            $dto->startDate,
            $dto->endDate,
            $dto->currency,
        );

        return $this->repository->store($result, $dto->userId);
    }
}

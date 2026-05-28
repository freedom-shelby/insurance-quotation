<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Repositories\QuotationRepository;
use App\Services\QuotationCalculatorService;
use DateTimeImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function __construct(
        private readonly QuotationCalculatorService $calculator,
        private readonly QuotationRepository $quotations,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function calculate(QuotationRequest $request): JsonResponse
    {
        $result = $this->calculator->calculate(
            ages: $request->input("age"),
            startDate: new DateTimeImmutable($request->input("start_date")),
            endDate: new DateTimeImmutable($request->input("end_date")),
            currency: Currency::from($request->input("currency_id")),
        );

        $user = Auth::guard("api")->user();
        $quotation = $this->quotations->store($result, $user->id);

        return response()->json([
            "quotation_id" => $quotation->id,
            "currency_id"  => $result->currency->value,
            "total"        => number_format($result->total, 2),
        ], 201);
    }
}

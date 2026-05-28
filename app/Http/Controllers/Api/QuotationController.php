<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Services\QuotationService;
use DateTimeImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function __construct(
        private readonly QuotationService $service,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function calculate(QuotationRequest $request): JsonResponse
    {
        $user = Auth::guard("api")->user();

        $quotation = $this->service->createQuotation(
            ages: $request->input("age"),
            startDate: new DateTimeImmutable($request->input("start_date")),
            endDate: new DateTimeImmutable($request->input("end_date")),
            currency: Currency::from($request->input("currency_id")),
            userId: $user->id,
        );

        return response()->json([
            "quotation_id" => $quotation->id,
            "currency_id"  => $quotation->currency_code->value,
            "total"        => number_format($quotation->total, 2),
        ], 201);
    }
}

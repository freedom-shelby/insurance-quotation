<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property mixed|string $age
 */
class QuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "age"         => ["required", "array", "min:1"],
            "age.*"       => ["integer", "min:18", "max:70"],
            "start_date"  => ["required", "date_format:Y-m-d", "after_or_equal:today"],
            "end_date"    => ["required", "date_format:Y-m-d", "after_or_equal:start_date"],
            "currency_id" => ["required", new Enum(Currency::class)],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!is_string($this->age)) {
            return;
        }

        $this->merge([
            'age' => array_map(
                static fn (string $value): int => (int)trim($value),
                explode(',', $this->age),
            ),
        ]);
    }
}

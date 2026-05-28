<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @property mixed $id
 */
class Quotation extends Model
{
    protected $fillable = [
        "user_id",
        "age",
        "start_date",
        "end_date",
        "trip_length",
        "fixed_rate",
        "age_load",
        "currency_code",
        "total",
    ];

    protected function casts(): array
    {
        return [
            "age"           => "array",
            "start_date"    => "date:Y-m-d",
            "end_date"      => "date:Y-m-d",
            "trip_length"   => "integer",
            "fixed_rate"    => "integer",
            "age_load"      => "array",
            "currency_code" => Currency::class,
            "total"         => "float",
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

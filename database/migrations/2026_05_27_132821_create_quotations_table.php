<?php

declare(strict_types=1);

use App\Enums\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('age');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('trip_length');
            $table->unsignedTinyInteger('fixed_rate');
            $table->json('age_load');
            $table->enum('currency_code', array_column(Currency::cases(), 'value'));
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};

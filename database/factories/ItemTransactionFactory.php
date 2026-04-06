<?php

namespace Database\Factories;

use App\Models\ItemTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * @extends Factory<ItemTransaction>
 */
class ItemTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::orderedUuid(),
            'item_id' => 1,
            'transaction_date' => Carbon::today(),
            'amount' => 123.45,
        ];
    }
}

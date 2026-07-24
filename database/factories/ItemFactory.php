<?php

namespace Database\Factories;

use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
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
            'item_type_id' => 1,
            'flow' => Flow::IN,
            'frequency' => Frequency::SINGLE,
            'start_date' => Carbon::today(),
            'number_of_transactions' => 1,
            'description' => $this->faker->words(5, true),
            'company_name' => $this->faker->words(2, true),
            'amount' => 123.45,
            'reference' => null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use App\Enums\Category;

/**
 * @extends Factory<ItemType>
 */
class ItemTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        $code = Str::slug($name, '_');

        return [
            'uuid' => Str::orderedUuid(),
            'category' => Category::INVESTING,
            'code' => $code,
            'name' => $name,
            'description' => $this->faker->words(5, true),
        ];
    }
}

<?php

use App\Models\ItemType;
use App\Enums\Category;
use App\Models\Item;
use Illuminate\Support\Collection;

test('Can Create Item Type', function () {
    $itemType = ItemType::factory()
        ->has(Item::factory()->count(3))
        ->create();

    expect($itemType)->toBeInstanceOf(ItemType::class);

    // Casts
    expect($itemType->category)->toBeInstanceOf(Category::class);

    // Relationships
    expect($itemType->items)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);
});

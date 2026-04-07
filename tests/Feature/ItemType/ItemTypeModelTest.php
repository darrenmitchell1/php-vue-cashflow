<?php

use App\Models\ItemType;
use App\Enums\Category;

test('Can Create Item Type', function () {
    $itemType = ItemType::factory()->create();

    expect($itemType)->toBeInstanceOf(ItemType::class);

    // Casts
    expect($itemType->category)->toBeInstanceOf(Category::class);
});

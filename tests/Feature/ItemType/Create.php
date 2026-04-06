<?php

use App\Models\ItemType;

test('Can Create Item Type', function () {
    $itemType = ItemType::factory()->create();

    expect($itemType)->toBeInstanceOf(ItemType::class);
});

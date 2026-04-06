<?php

use App\Models\ItemType;
use App\Models\Item;

test('Can Create Item', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create();

    expect($item)->toBeInstanceOf(Item::class);
});

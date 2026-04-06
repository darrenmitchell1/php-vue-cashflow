<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Models\ItemTransaction;

test('Can Create Item Transaction', function () {
    $itemTransaction = ItemTransaction::factory()
            ->for(Item::factory()
                ->for(ItemType::factory()->create())
                ->create())
            ->create();

    expect($itemTransaction)->toBeInstanceOf(ItemTransaction::class);
});

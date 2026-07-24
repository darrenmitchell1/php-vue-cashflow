<?php

use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\ItemType;
use Carbon\CarbonImmutable;

test('Can Create Item Transaction', function () {
    $itemTransaction = ItemTransaction::factory()
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create())
        ->create();

    expect($itemTransaction)->toBeInstanceOf(ItemTransaction::class);

    // Casts
    expect($itemTransaction->transaction_date)->toBeInstanceOf(CarbonImmutable::class);

    // Relationships
    expect($itemTransaction->item)->toBeInstanceOf(Item::class);
});

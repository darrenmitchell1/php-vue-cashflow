<?php

use Carbon\CarbonImmutable;
use App\Models\ItemType;
use App\Models\Item;

use App\Enums\Flow;
use App\Enums\Frequency;

test('Can Create Item', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create();

    expect($item)->toBeInstanceOf(Item::class);

    // Casts
    expect($item->flow)->toBeInstanceOf(Flow::class);
    expect($item->frequency)->toBeInstanceOf(Frequency::class);
    expect($item->start_date)->toBeInstanceOf(CarbonImmutable::class);
    expect($item->end_date)->toBeInstanceOf(CarbonImmutable::class);

    // Relationships
    expect($item->itemType)->toBeInstanceOf(ItemType::class);
});

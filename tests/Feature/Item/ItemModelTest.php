<?php

use Carbon\CarbonImmutable;
use App\Models\ItemType;
use App\Models\Item;

use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\ItemTransaction;
use Illuminate\Support\Collection;

test('Can Create Item', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->has(ItemTransaction::factory()->count(3))
            ->create();

    expect($item)->toBeInstanceOf(Item::class);

    // Casts
    expect($item->flow)->toBeInstanceOf(Flow::class);
    expect($item->frequency)->toBeInstanceOf(Frequency::class);
    expect($item->start_date)->toBeInstanceOf(CarbonImmutable::class);
    expect($item->end_date)->toBeInstanceOf(CarbonImmutable::class);

    // Relationships
    expect($item->itemType)->toBeInstanceOf(ItemType::class);
    expect($item->itemTransactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);
});

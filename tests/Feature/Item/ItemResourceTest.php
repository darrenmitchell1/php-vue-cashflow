<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Http\Resources\ItemResource;

test('Item Type transformed to Resource', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create();
    
    $itemTypeResource = (new ItemResource($item))->resolve();

    expect($itemTypeResource)
        ->toBeArray()
        ->toHaveCount(11)
        ->toHaveKey('id')
        ->toHaveKey('item_type')
        ->toHaveKey('flow')
        ->toHaveKey('frequency')
        ->toHaveKey('start_date')
        ->toHaveKey('end_date')
        ->toHaveKey('number_of_transactions')
        ->toHaveKey('description')
        ->toHaveKey('company_name')
        ->toHaveKey('amount')
        ->toHaveKey('reference');

    expect($itemTypeResource['flow'])
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKey('id')
        ->toHaveKey('label');

    expect($itemTypeResource['frequency'])
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKey('id')
        ->toHaveKey('label');
});

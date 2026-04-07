<?php

use App\Http\Resources\ItemTypeResource;
use App\Models\ItemType;

test('Item Type transformed to Resource', function () {
    $itemTypeResource = (new ItemTypeResource(ItemType::factory()->create()))->resolve();

    expect($itemTypeResource)
        ->toBeArray()
        ->toHaveCount(5)
        ->toHaveKey('id')
        ->toHaveKey('category')
        ->toHaveKey('code')
        ->toHaveKey('name')
        ->toHaveKey('description');

    expect($itemTypeResource['category'])
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKey('id')
        ->toHaveKey('label');
});

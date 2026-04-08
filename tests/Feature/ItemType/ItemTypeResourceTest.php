<?php

use App\Http\Resources\ItemTypeResource;
use App\Models\ItemType;

test('Item Type transformed to Resource', function () {
    $itemTypeResource = (new ItemTypeResource(ItemType::factory()->create()))->resolve();

    expect($itemTypeResource)
        ->toBeArray()
        ->toHaveCount(6)
        ->toHaveKey('id')
        ->toHaveKey('category')
        ->toHaveKey('code')
        ->toHaveKey('name')
        ->toHaveKey('description')
        ->toHaveKey('deleted_at');

    expect($itemTypeResource['category'])
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKey('id')
        ->toHaveKey('label');
});

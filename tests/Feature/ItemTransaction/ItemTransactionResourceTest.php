<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Models\ItemTransaction;
use App\Http\Resources\ItemTransactionResource;

test('Item Transaction transformed to Resource', function () {
    $itemTransaction = ItemTransaction::factory()
            ->for(Item::factory()
                ->for(ItemType::factory()->create())
                ->create())
            ->create();
    
    $itemTransactionResource = (new ItemTransactionResource($itemTransaction))->resolve();

    expect($itemTransactionResource)
        ->toBeArray()
        ->toHaveCount(4)
        ->toHaveKey('id')
        ->toHaveKey('item')
        ->toHaveKey('transaction_date')
        ->toHaveKey('amount');
});
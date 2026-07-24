<?php

use App\Models\CashflowEmbedding;
use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\ItemType;
use App\Services\CashflowEmbeddingService;

test('Create Embedding for a Transaction', function () {
    $itemTransaction = ItemTransaction::factory()
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create())
        ->create();

    $embedding = CashflowEmbeddingService::create($itemTransaction);

    expect($embedding)
        ->toBeInstanceOf(CashflowEmbedding::class);
});

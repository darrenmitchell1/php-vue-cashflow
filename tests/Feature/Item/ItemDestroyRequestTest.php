<?php

use App\Models\Item;
use App\Models\ItemType;

test('destroy item', function () {
    $item = Item::factory()
        ->for(ItemType::factory()->create())
        ->create();

    expect($item->trashed())->toBeFalse();

    $response = $this->deleteJson(route('items.destroy', ['item' => $item->uuid]));

    $response->assertStatus(200);

    expect($item->fresh()->trashed())->toBeTrue();
});
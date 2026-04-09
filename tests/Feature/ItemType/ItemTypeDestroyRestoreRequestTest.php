<?php

use App\Models\ItemType;

test('destroy item type', function () {
    $itemType = ItemType::factory()->create();

    expect($itemType->trashed())->toBeFalse();

    $response = $this->deleteJson(route('item_types.destroy', ['itemType' => $itemType->uuid]));

    $response->assertStatus(200);

    expect($itemType->fresh()->trashed())->toBeTrue();
});

test('restore item type', function () {
    $itemType = ItemType::factory()->create();

    $itemType->delete();

    expect($itemType->trashed())->toBeTrue();

    $response = $this->patchJson(route('item_types.restore', ['itemType' => $itemType->uuid]));

    $response->assertStatus(200);

    expect($itemType->fresh()->trashed())->toBeFalse();
});
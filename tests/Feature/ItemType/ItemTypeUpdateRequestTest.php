<?php

use App\Enums\Category;
use App\Models\ItemType;

test('update item type success', function () {
    $itemType = ItemType::factory()->create([
        'category' => Category::OPERATING->value,
        'code' => 'purchase_stock',
        'name' => 'Purchase Stock',
        'description' => 'Purchase of Stock'
    ]);

    $params = [
        'itemType' => $itemType->uuid,
        'category' => 'invalid',  // should ignore
        'code' => 'purchase_stock',  // should ignore
        'name' => 'Buy Stock',
        'description' => 'Buy Stock Materials',
    ];

    $response = $this->patchJson(route('item_types.update', $params));

    $response->assertStatus(302);
});

test('update item type unique name error', function () {
    ItemType::factory()->create([
        'category' => Category::INVESTING->value,
        'code' => 'purchase_property',
        'name' => 'Purchase Property',
        'description' => 'Purchase of Property'
    ]);

    $itemType = ItemType::factory()->create([
        'category' => Category::OPERATING->value,
        'code' => 'purchase_stock',
        'name' => 'Purchase Stock',
        'description' => 'Purchase of Stock'
    ]);

    $params = [
        'itemType' => $itemType->uuid,
        'category' => 'invalid',  // should ignore
        'code' => 'purchase_stock',  // should ignore
        'name' => ' purchase  property ',
        'description' => 'Purchase of Property',
    ];

    $response = $this->patchJson(route('item_types.update', $params));

    $response
        ->assertJsonCount(1, 'errors')
        ->assertJsonValidationErrorFor('name', 'errors')
        ->assertStatus(422);
});

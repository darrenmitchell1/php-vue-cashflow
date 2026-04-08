<?php

use App\Enums\Category;
use App\Models\ItemType;

test('create item type success', function () {
    $payload = [
        'category' => Category::OPERATING->value,
        'code' => 'purchase_stock',
        'name' => 'Purchase Stock',
        'description' => 'Purchase of Stock',
    ];

    $response = $this->postJson(route('item_types.store', $payload));

    $response->assertStatus(200);
});

test('create item type unique error', function () {
    $payload = [
        'category' => 'invalid',
        'code' => 'purchase_stock',
        'name' => 'Purchase Stock',
        'description' => 'Purchase of Stock',
    ];

    ItemType::factory()->create(array_merge($payload, ['category' => Category::OPERATING->value, 'name' => ' purchase  stock ']));

    $response = $this->postJson(route('item_types.store', $payload));

    $response
        ->assertJsonValidationErrorFor('category', 'errors')
        ->assertJsonValidationErrorFor('code', 'errors')
        ->assertJsonValidationErrorFor('name', 'errors')
        ->assertStatus(422);
});

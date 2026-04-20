<?php

use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\ItemType;
use Carbon\Carbon;

test('create item success', function () {
    $payload = [
        'item_type_id' => (string)ItemType::factory()->create()->uuid,
        'flow' => Flow::IN->value,
        'frequency' => Frequency::SINGLE->value,
        'start_date' => Carbon::parse('2026-01-29')->format('Y-m-d'),
        'number_of_transactions' => 1,
        'description' => 'Purchase of Stock',
        'company_name' => 'A Supplier',
        'amount' => '1234.56',
        'reference' => 'a1',
    ];

    $response = $this->postJson(route('items.store', $payload));

    $response->assertStatus(200);
});

test('Monthly > 28th Error', function () {
    $payload = [
        'item_type_id' => (string)ItemType::factory()->create()->uuid,
        'flow' => Flow::IN->value,
        'frequency' => Frequency::MONTHLY->value,
        'start_date' => Carbon::parse('2026-01-29')->format('Y-m-d'),
        'number_of_transactions' => 1,
        'description' => 'Purchase of Stock',
        'company_name' => 'A Supplier',
        'amount' => '1234.56',
        'reference' => 'a1',
    ];

    $response = $this->postJson(route('items.store', $payload));

    $response
        ->assertJsonCount(1, 'errors')
        ->assertJsonValidationErrorFor('start_date', 'errors')
        ->assertStatus(422);
});
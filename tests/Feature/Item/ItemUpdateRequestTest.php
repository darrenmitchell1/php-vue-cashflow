<?php

use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\Item;
use App\Models\ItemType;
use Carbon\Carbon;

test('update item success', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create();

    $payload = [
        'item' => $item->uuid,
        'item_type_id' => $item->itemType->uuid,
        'flow' => Flow::IN->value,
        'frequency' => Frequency::SINGLE->value,
        'start_date' => Carbon::today()->format('Y-m-d'),
        'number_of_transactions' => 1,
        'description' => 'Purchase of Stock',
        'company_name' => 'A Supplier',
        'amount' => '1234.56',
        //'reference' => 'a1',
    ];

    $response = $this->patchJson(route('items.update', $payload));

    $response->assertStatus(200);
});
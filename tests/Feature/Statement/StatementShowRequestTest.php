<?php

use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\ItemType;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

// @TODO not complete
test('show statement success', function () {
    // Opening IN
    ItemTransaction::factory(4)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'in']))
        ->create(['transaction_date' => Carbon::today()->subDay(),  'amount' => 2]);

    // Statement IN
    ItemTransaction::factory(5)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'in']))
        ->create(['transaction_date' => Carbon::today(),  'amount' => 3]);

    // Future IN
    ItemTransaction::factory(1)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'in']))
        ->create(['transaction_date' => Carbon::today()->addDay(),  'amount' => 4]);

    // Opening OUT
    ItemTransaction::factory(6)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'out']))
        ->create(['transaction_date' => Carbon::today()->subDay(), 'amount' => 4]);

    // Statement OUT
    ItemTransaction::factory(7)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'out']))
        ->create(['transaction_date' => Carbon::today(), 'amount' => 5]);

    // Future OUT
    ItemTransaction::factory(1)
        ->for(Item::factory()
            ->for(ItemType::factory()->create())
            ->create(['flow' => 'out']))
        ->create(['transaction_date' => Carbon::today()->addDay(), 'amount' => 5]);

    $payload = [
        'period_from' => Carbon::today()->format('Y-m-d'),
        'period_to' => Carbon::today()->format('Y-m-d'),
    ];

    $response = $this->getJson(route('statement.show', $payload));

    $response
        ->assertStatus(200)
        ->assertJsonCount(7, 'statement')
        ->assertJsonStructure([
            'statement' => [
                'period_from',
                'period_to',
                'opening_in_balance_amount',
                'opening_out_balance_amount',
                'closing_in_balance_amount',
                'closing_out_balance_amount',
                'item_categories'
            ]
        ])
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('statement', fn (AssertableJson $json) => 
                $json->where('period_from', Carbon::today()->toIso8601String())
                    ->where('period_to', Carbon::today()->toIso8601String())
                    ->where('opening_in_balance_amount', 8)
                    ->where('opening_out_balance_amount', 24)
                    ->where('closing_in_balance_amount', 15)
                    ->where('closing_out_balance_amount', 35)
                    ->has('item_categories')
            )
        );
});
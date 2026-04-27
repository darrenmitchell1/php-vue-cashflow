<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Enums\Flow;
use App\Enums\Frequency;
use App\Services\ItemService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test('Adjust for Number of Transactions', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::WEEKLY,
                'start_date' => Carbon::today()->addDay(),
                'number_of_transactions' => 3,
                'amount' => 1.23
                ]);

    (new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    $item->update([
        'number_of_transactions' => 5,
    ]);

    (new ItemService($item))->adjustNumberOfTransactions();

    $item->refresh();
    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(5);

    expect($transactions->first()->transaction_date)->toEqual(Carbon::today()->addDay()->toImmutable());
    expect($transactions->last()->transaction_date)->toEqual(Carbon::today()->addDay()->addWeeks(4)->toImmutable());    
});
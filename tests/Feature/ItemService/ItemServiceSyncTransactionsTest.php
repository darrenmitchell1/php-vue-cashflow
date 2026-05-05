<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Enums\Flow;
use App\Enums\Frequency;
use App\Services\ItemService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test('Adjust for Transaction Date Change', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::WEEKLY,
                'start_date' => Carbon::today()->addDay(),
                'number_of_transactions' => 3,
                'amount' => 1.23
                ]);

    ($itemService = new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $key => $transaction) {
        expect($transaction->transaction_date)->toEqual(Carbon::today()->addDay()->addWeeks($key)->toImmutable());
        expect($transaction->amount)->toEqual(1.23);
    }

    $item->update([
        'flow' => Flow::OUT,
        'frequency' => Frequency::MONTHLY,
        'start_date' => Carbon::today()->day(20)->addDays(5),
        'amount' => -4.56
    ]);

    $itemService->deleteTransactions();
    $itemService->createTransactions();

    $item->refresh();
    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $key => $transaction) {
        expect($transaction->transaction_date)->toEqual(Carbon::today()->day(20)->addDays(5)->addMonths($key)->toImmutable());
        expect($transaction->amount)->toEqual(-4.56);
    }
});

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

    (new ItemService($item))->syncNumberOfTransactions();

    $item->refresh();
    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(5);
});

test('Adjust for Flow or Amount', function () {
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

    foreach ($transactions as $transaction) {
        expect($transaction->amount)->toEqual(1.23);
    }

    $item->update([
        'flow' => Flow::OUT,
        'amount' => -4.56
    ]);

    (new ItemService($item))->syncTransactionAmounts();

    $item->refresh();
    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $transaction) {
        expect($transaction->amount)->toEqual(-4.56);
    }
});
<?php

use App\Models\ItemType;
use App\Models\Item;
use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\ItemTransaction;
use App\Services\ItemService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test('Create Transactions for Single', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::SINGLE,
                'start_date' => Carbon::today()->addDay(),
                'number_of_transactions' => 1,
                'amount' => 1.23
                ]);

    (new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);

    $transaction = $transactions->first();
    expect($transaction)->toBeInstanceOf(ItemTransaction::class);

    expect($transaction->transaction_date)->toEqual(Carbon::today()->addDay()->toImmutable());
    expect($transaction->amount)->toEqual(1.23);
});

test('Create Transactions for Daily', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::DAILY,
                'start_date' => Carbon::today()->addDay(),
                'number_of_transactions' => 3,
                'amount' => 2.34
                ]);

    (new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $key => $transaction) {
        expect($transaction)->toBeInstanceOf(ItemTransaction::class);

        expect($transaction->transaction_date)->toEqual(Carbon::today()->addDay()->addDays($key)->toImmutable());
        expect($transaction->amount)->toEqual(2.34);
    }
});

test('Create Transactions for Weekly', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::WEEKLY,
                'start_date' => Carbon::today()->addDay(),
                'number_of_transactions' => 3,
                'amount' => 3.45
                ]);

    (new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $key => $transaction) {
        expect($transaction)->toBeInstanceOf(ItemTransaction::class);
        expect($transaction->transaction_date)->toEqual(Carbon::today()->addDay()->addWeeks($key)->toImmutable());
        expect($transaction->amount)->toEqual(3.45);
    }
});

test('Create Transactions for Monthly', function () {
    $item = Item::factory()
            ->for(ItemType::factory()->create())
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::MONTHLY,
                'start_date' => Carbon::parse('2026-01-28'),
                'number_of_transactions' => 3,
                'amount' => 4.56
                ]);

    (new ItemService($item))->createTransactions();

    $transactions = $item->itemTransactions;

    expect($transactions)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);

    foreach ($transactions as $key => $transaction) {
        expect($transaction)->toBeInstanceOf(ItemTransaction::class);

        expect($transaction->transaction_date)->toEqual(Carbon::parse('2026-01-28')->addMonths($key)->toImmutable());
        expect($transaction->amount)->toEqual(4.56);
    }
});

<?php

use App\Enums\Category;
use App\Enums\Flow;
use App\Enums\Frequency;
use App\Models\Item;
use App\Models\ItemType;
use App\Services\ItemService;
use App\Services\StatementService;
use Carbon\Carbon;

test('No Items Found', function () {
    // 7 day reporting period
    $periodFrom = Carbon::today();
    $periodTo = Carbon::today()->addDays(7);

    $beforePeriodItem = Item::factory()
            ->for(ItemType::factory()
                ->create([
                    'category' => Category::OPERATING
                ]))
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::DAILY,
                'start_date' => (clone $periodFrom)->subDays(5),
                'number_of_transactions' => 2,
                'amount' => 1
            ]);
    (new ItemService($beforePeriodItem))->createTransactions();

    $statementData = StatementService::buildStatementData($periodFrom, $periodTo);

    expect($statementData['period_from'])->toBe($periodFrom->toIso8601String());
    expect($statementData['period_to'])->toBe($periodTo->toIso8601String());
    expect($statementData['opening_in_balance_amount'])->toBe(2.00);
    expect($statementData['opening_out_balance_amount'])->toBe(0);
    expect($statementData['closing_in_balance_amount'])->toBe(0);
    expect($statementData['closing_out_balance_amount'])->toBe(0);
    expect(count($statementData['item_categories'][Category::OPERATING->value]))->toBe(3);
    expect($statementData['item_categories'][Category::OPERATING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::OPERATING->value]['category_out_period_amount'])->toBe(0);
    expect(count($statementData['item_categories'][Category::INVESTING->value]))->toBe(3);
    expect($statementData['item_categories'][Category::INVESTING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::INVESTING->value]['category_out_period_amount'])->toBe(0);
    expect(count($statementData['item_categories'][Category::FINANCING->value]))->toBe(3);
    expect($statementData['item_categories'][Category::FINANCING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::FINANCING->value]['category_out_period_amount'])->toBe(0);
});

test('Item Found on Period From Date', function () {
    // 7 day reporting period
    $periodFrom = Carbon::today();
    $periodTo = Carbon::today()->addDays(7);

    $beforePeriodItem = Item::factory()
            ->for(ItemType::factory()
                ->create([
                    'category' => Category::OPERATING
                ]))
            ->create([
                'flow' => Flow::IN,
                'frequency' => Frequency::DAILY,
                'start_date' => (clone $periodFrom)->subDays(5),
                'number_of_transactions' => 2,
                'amount' => 1
            ]);
    (new ItemService($beforePeriodItem))->createTransactions();

    $startPeriodItem = Item::factory()
            ->for(ItemType::factory()
                ->create([
                    'category' => Category::INVESTING
                ]))
            ->create([
                'flow' => Flow::OUT,
                'frequency' => Frequency::DAILY,
                'start_date' => (clone $periodFrom)->subDays(1),
                'number_of_transactions' => 2,
                'amount' => -2
            ]);
    (new ItemService($startPeriodItem))->createTransactions();

    $statementData = StatementService::buildStatementData($periodFrom, $periodTo);

    expect($statementData['period_from'])->toBe($periodFrom->toIso8601String());
    expect($statementData['period_to'])->toBe($periodTo->toIso8601String());
    expect($statementData['opening_in_balance_amount'])->toBe(2.00);
    expect($statementData['opening_out_balance_amount'])->toBe(-2.00);
    expect($statementData['closing_in_balance_amount'])->toBe(0);
    expect($statementData['closing_out_balance_amount'])->toBe(-2.00);

    expect(count($statementData['item_categories'][Category::OPERATING->value]))->toBe(3);
    expect($statementData['item_categories'][Category::OPERATING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::OPERATING->value]['category_out_period_amount'])->toBe(0);

    expect(count($statementData['item_categories'][Category::INVESTING->value]))->toBe(4);
    expect($statementData['item_categories'][Category::INVESTING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::INVESTING->value]['category_out_period_amount'])->toBe(-2.00);
    expect($statementData['item_categories'][Category::INVESTING->value][$startPeriodItem->itemType->code]['item_type_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::INVESTING->value][$startPeriodItem->itemType->code]['item_type_out_period_amount'])->toBe(-2.00);
    expect(count($statementData['item_categories'][Category::INVESTING->value][$startPeriodItem->itemType->code]['items']))->toBe(1);

    expect(count($statementData['item_categories'][Category::FINANCING->value]))->toBe(3);
    expect($statementData['item_categories'][Category::FINANCING->value]['category_in_period_amount'])->toBe(0);
    expect($statementData['item_categories'][Category::FINANCING->value]['category_out_period_amount'])->toBe(0);
});
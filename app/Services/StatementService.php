<?php

namespace App\Services;

use App\Enums\Category;
use App\Enums\Flow;
use App\Models\ItemTransaction;
use App\Models\ItemType;
use Carbon\CarbonImmutable;

class StatementService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the Data for the Statement
     *
     * @param CarbonImmutable $periodFrom
     * @param CarbonImmutable $periodTo
     * @return array
     */
    public static function buildStatementData(CarbonImmutable $periodFrom, CarbonImmutable $periodTo): array
    {
        $itemTypes = ItemType::withTrashed()
            ->with([
                'items' => function ($query) use ($periodFrom, $periodTo) {
                    $query->with(['itemTransactions'])
                        ->where('start_date', '<=', $periodTo)
                        ->whereNotNull('item_transactions_sum_amount')  // ignore where no transactions found
                        ->withSum([
                            'itemTransactions' => function ($query) use ($periodFrom, $periodTo) {
                                $query->whereBetween('transaction_date', [$periodFrom, $periodTo]);
                            }], 'amount');

                }])
            ->get();

        // build the statement item structure
        // set the order of the categories
        $itemCategoryies = [
            Category::OPERATING->value => ['category' => Category::OPERATING->toResource(), 'category_in_period_amount' => 0, 'category_out_period_amount' => 0],
            Category::INVESTING->value => ['category' => Category::INVESTING->toResource(), 'category_in_period_amount' => 0, 'category_out_period_amount' => 0],
            Category::FINANCING->value => ['category' => Category::FINANCING->toResource(), 'category_in_period_amount' => 0, 'category_out_period_amount' => 0]
        ];
        foreach ($itemTypes as $itemType) {
            // skip the type where no items
            if ($itemType->items->isEmpty()) {
                continue;
            }
            $itemCategoryies[$itemType->category->value][$itemType->code]['itemType'] = $itemType->toResource();
            $itemCategoryies[$itemType->category->value][$itemType->code]['item_type_in_period_amount'] = 0;
            $itemCategoryies[$itemType->category->value][$itemType->code]['item_type_out_period_amount'] = 0;
            foreach ($itemType->items as $item) {
                if ($item->flow === Flow::IN) {
                    $itemCategoryies[$itemType->category->value]['category_in_period_amount'] += $item->item_transactions_sum_amount;
                    $itemCategoryies[$itemType->category->value][$itemType->code]['item_type_in_period_amount'] += $item->item_transactions_sum_amount;
                } else {
                    $itemCategoryies[$itemType->category->value]['category_out_period_amount'] += $item->item_transactions_sum_amount;
                    $itemCategoryies[$itemType->category->value][$itemType->code]['item_type_out_period_amount'] += $item->item_transactions_sum_amount;
                }

                $itemCategoryies[$itemType->category->value][$itemType->code]['items'][] = [
                    'item' => $item->toResource(),
                    'item_period_amount' => $item->item_transactions_sum_amount,
                ];
            }
        }
 
        // ensure date formats are YYYY-MM-DDTHH:MM:SS.uuuuuuZ
        return [
            'period_from' => $periodFrom->toIso8601String(),
            'period_to' => $periodTo->toIso8601String(),
            'opening_in_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'in')
                ->whereDate('transaction_date', '<', $periodFrom)
                ->sum('amount'),
            'opening_out_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'out')
                ->whereDate('transaction_date', '<', $periodFrom)
                ->sum('amount'),
            'closing_in_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'in')
                ->whereBetween('transaction_date', [$periodFrom, $periodTo])
                ->sum('amount'),
            'closing_out_balance_amount' => ItemTransaction::whereRelation ('item', 'flow', 'out')
                ->whereBetween('transaction_date', [$periodFrom, $periodTo])
                ->sum('amount'),
            'item_categories' => $itemCategoryies,
        ];
    }
}

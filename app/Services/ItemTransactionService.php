<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemTransaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ItemTransactionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a Transaction for an Item
     *
     * @param Item $item
     * @param Carbon $transactionDate
     * @return ItemTransaction
     */
    public static function create(Item $item, Carbon $transactionDate): ItemTransaction
    {
        return ItemTransaction::create([
            'uuid' => Str::orderedUuid(),
            'item_id' => $item->id,
            'transaction_date' => $transactionDate,
            'amount' => $item->amount
        ]);
    }

    /**
     * Update a Transaction for an Item
     *
     * @param Item $item
     * @param ItemTransaction $itemTransaction
     * @param Carbon $transactionDate
     * @return ItemTransaction
     */
    public static function update(Item $item, ItemTransaction $itemTransaction, Carbon $transactionDate): ItemTransaction
    {
        $itemTransaction->update([
            'transaction_date' => $transactionDate,
            'amount' => $item->amount
        ]);

        return $itemTransaction;
    }
}

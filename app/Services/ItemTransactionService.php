<?php

namespace App\Services;

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
     * @param integer $itemId
     * @param Carbon $transactionDate
     * @param float $amount
     * @return ItemTransaction
     */
    public static function create(int $itemId, Carbon $transactionDate, float $amount): ItemTransaction
    {
        return ItemTransaction::create([
            'uuid' => Str::orderedUuid(),
            'item_id' => $itemId,
            'transaction_date' => $transactionDate,
            'amount' => $amount
        ]);
    }
}

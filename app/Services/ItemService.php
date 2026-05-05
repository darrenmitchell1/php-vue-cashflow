<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemTransaction;

class ItemService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Item $item,
    )
    {
        //
    }

    /**
     * Create Transactions for the Item
     * 
     * The last transaction date will be the so need to reduce num of trans by one so dates are correct
     * eg. 1 transaction would start and end on same date
     *
     * @return void
     */
    public function createTransactions()
    {
        $interval = $this->item->frequency->interval();
        $startDate = $this->item->start_date->toMutable();

        // add interval afterwards as first transaction date should start on start date
        for ($x = 0; $x < $this->item->number_of_transactions; $x++) {
            ItemTransactionService::create($this->item, $startDate);

            $startDate->add($interval);
        }
    }

    /**
     * Delete Transactions for the Item
     *
     * @return void
     */
    public function deleteTransactions()
    {
        $this->item->itemTransactions()->delete();
    }

    /**
     * Update Transaction Amounts for the Item
     *
     * @return void
     */
    public function syncTransactionAmounts()
    {
        $this->item->itemTransactions()->update(['amount' => $this->item->amount]);
    }

    /**
     * Create/Update/Delete so the number of Transactions are in Sync with the Item
     *
     * @return void
     */
    public function syncNumberOfTransactions()
    {
        $interval = $this->item->frequency->interval();
        $startDate = $this->item->start_date->toMutable();

        // delete any transactions that are before the start date
        $this->item->itemTransactions()->whereDate('transaction_date', '<', $startDate)->delete();

        // delete any transactions that are after the final transaction date
        $this->item->itemTransactions()->whereDate('transaction_date', '>', $this->item->end_date)->delete();

        // create/update transactions
        for ($x = 0; $x < $this->item->number_of_transactions; $x++) {
            $itemTransaction = ItemTransaction::whereDate('transaction_date', $startDate)->first();

            if (!($itemTransaction instanceof ItemTransaction)) {
                ItemTransactionService::create($this->item, $startDate);
            }

            $startDate->add($interval);
        }
    }
}

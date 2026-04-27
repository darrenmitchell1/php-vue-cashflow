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
     * @return void
     */
    public function createTransactions()
    {
        $interval = $this->item->frequency->interval();
        $startDate = $this->item->start_date->toMutable();

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
     * Update the Amount on all item transactions
     *
     * @return void
     */
    public function updateTransactionsAmount()
    {
        $this->item->itemTransactions()->update(['amount' => $this->item->amount]);
    }

    /**
     * Create/Update/Delete Transactions so they are in Sync with the Item
     *
     * @return void
     */
    public function adjustNumberOfTransactions()
    {
        $interval = $this->item->frequency->interval();
        $totalInterval = $this->item->frequency->interval($this->item->number_of_transactions);
        $startDate = $this->item->start_date->toMutable();

        // delete any transactions that are before the start date
        $this->item->itemTransactions()->whereDate('transaction_date', '<', $startDate)->delete();

        // delete any transactions that are after the end date
        $this->item->itemTransactions()->whereDate('transaction_date', '>', (clone $startDate)->add($totalInterval))->delete();

        // create/update transactions
        for ($x = 0; $x < $this->item->number_of_transactions; $x++) {
            print_r($startDate->format('Y-m-d') . '  ');
            $itemTransaction = ItemTransaction::whereDate('transaction_date', $startDate)->first();

            if ($itemTransaction instanceof ItemTransaction) {
                ItemTransactionService::update($this->item, $itemTransaction, $startDate);
                print_r('  U  ');
            } else {
                ItemTransactionService::create($this->item, $startDate);
                print_r('  I  ');
            }

            $startDate->add($interval);
        }
    }
}

<?php

namespace App\Services;

use App\Models\Item;

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
            ItemTransactionService::create($this->item->id, $startDate, $this->item->amount);

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
}

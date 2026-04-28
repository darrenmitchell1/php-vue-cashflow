<?php

namespace App\Listeners;

use App\Events\ItemUpdated;
use App\Services\ItemService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class UpdateItemTransactions
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ItemUpdated $event): void
    {
        $itemService = new ItemService($event->item);

        if ($this->hasChanged($event->itemChanges, 'frequency') || $this->hasChanged($event->itemChanges, 'start_date')) {
            // major change so just delete and rebuild transactions
            $itemService->deleteTransactions();
            $itemService->createTransactions();
        } else {
            if ($this->hasChanged($event->itemChanges, 'number_of_transactions')) {
                $itemService->syncNumberOfTransactions();
            }
            
            if ($this->hasChanged($event->itemChanges, 'flow') || $this->hasChanged($event->itemChanges, 'amount')) {
                $itemService->syncTransactionAmounts();
            }
        }
    }

    /**
     * Check a key value has chnaged
     *
     * @param array $itemChanges
     * @param string $key
     * @return boolean
     */
    private function hasChanged(array $itemChanges, string $key): bool
    {
        if (
            (array_key_exists($key, $itemChanges['old']) ? $itemChanges['old'][$key] : null)
            !==
            (array_key_exists($key, $itemChanges['new']) ? $itemChanges['new'][$key] : null)
        ) {
            return true;
        }

        return false;
    }    

    /**
     * Handle a job failure.
     */
    public function failed(ItemUpdated $event, Throwable $exception): void
    {
        report($exception);
    }
}

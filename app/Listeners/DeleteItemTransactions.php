<?php

namespace App\Listeners;

use App\Events\ItemDeleted;
use App\Services\ItemService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteItemTransactions
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
    public function handle(ItemDeleted $event): void
    {
        (new ItemService($event->item))->deleteTransactions();
    }
}

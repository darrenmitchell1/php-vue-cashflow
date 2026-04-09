<?php

namespace App\Listeners;

use App\Events\ItemCreated;
use App\Services\ItemService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateItemTransactions
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
    public function handle(ItemCreated $event): void
    {
        (new ItemService($event->item))->createTransactions();
    }
}

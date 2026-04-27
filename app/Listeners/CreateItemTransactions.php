<?php

namespace App\Listeners;

use App\Events\ItemCreated;
use App\Services\ItemService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

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

    /**
     * Handle a job failure.
     */
    public function failed(ItemCreated $event, Throwable $exception): void
    {
        report($exception);
    }
}

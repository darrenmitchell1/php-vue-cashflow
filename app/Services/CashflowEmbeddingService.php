<?php

namespace App\Services;

use App\Models\CashflowEmbedding;
use App\Models\ItemTransaction;
use Illuminate\Support\Str;

class CashflowEmbeddingService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Create an Embedding for a Transaction
     */
    public static function create(ItemTransaction $itemTransaction): CashflowEmbedding
    {
        $textChunk = "On {$itemTransaction->transaction_date->format('Y-m-d')}, a cashflow transaction of {$itemTransaction->amount} occurred. ".
                    "Details Description: ($itemTransaction->item->description), Company: {$itemTransaction->item->company_name}, Reference: {$itemTransaction->item->reference}".
                    "This was an {$itemTransaction->item->itemType->category->value} categorized under '{$itemTransaction->item->itemType->name}' with description '{$itemTransaction->item->itemType->description}'. ";

        return CashflowEmbedding::create([
            'uuid' => Str::orderedUuid(),
            'item_transaction_id' => $itemTransaction->id,
            'content' => $textChunk,
            'embedding' => Str::of($textChunk)->toEmbeddings(),
        ]);
    }
}

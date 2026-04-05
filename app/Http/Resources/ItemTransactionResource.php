<?php

namespace App\Http\Resources;

use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ItemTransaction $this */

        return [
            'id' => $this->uuid,
            'item' => $this->whenLoaded('item', fn () => $this->itemType->toResource()),
            'transaction_date' => $this->transaction_date->format('Y-m-d'),
            'amount' => $this->amount
        ];
    }
}

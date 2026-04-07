<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Item $this */

        return [
            'id' => $this->uuid,
            'item_type' => $this->whenLoaded('item_type', fn () => $this->itemType->toResource(), null),
            'flow' => [
                            'id' => $this->flow->value,
                            'label' => $this->flow->label()
                        ],
            'frequency' => [
                            'id' => $this->frequency->value,
                            'label' => $this->frequency->label()
                        ],
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
            'company_name' => $this->company_name,
            'amount' => $this->amount,
            'reference' => $this->refernce
        ];
    }
}

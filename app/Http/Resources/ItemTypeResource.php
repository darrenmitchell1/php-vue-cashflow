<?php

namespace App\Http\Resources;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ItemType $this */

        return [
            'id' => $this->uuid,
            'category' => [
                            'id' => $this->category->value,
                            'label' => $this->category->label()
                        ],
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

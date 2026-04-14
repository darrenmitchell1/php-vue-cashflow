<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Category: string
{
    case INVESTING = 'investing';

    case FINANCING = 'financing';

    case OPERATING = 'operating';

    public function label(): string
    {
        return Str::headline($this->value);
    }

    public function toResource(): array
    {
        return [
                'id' => $this->value,
                'label' => $this->label()
            ];
    }

    public static function toCollectionResource(): Collection
    {
        return collect(
            [
                self::INVESTING->toResource(),
                self::FINANCING->toResource(),
                self::OPERATING->toResource(),
            ]
        );
    }
}

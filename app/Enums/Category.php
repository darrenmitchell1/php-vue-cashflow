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
                [
                    'id' => self::INVESTING->value,
                    'label' => self::INVESTING->label()
                ],
                [
                    'id' => self::FINANCING->value,
                    'label' => self::FINANCING->label()
                ],
                [
                    'id' => self::OPERATING->value,
                    'label' => self::OPERATING->label()
                ]
            ]
        );
    }
}

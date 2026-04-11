<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Flow: string
{
    case IN = 'in';

    case OUT = 'out';

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
                    'id' => self::IN->value,
                    'label' => self::IN->label()
                ],
                [
                    'id' => self::OUT->value,
                    'label' => self::OUT->label()
                ],
            ]
        );
    }
}

<?php

namespace App\Enums;

use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Frequency: string
{
    case SINGLE = 'single';

    case DAILY = 'daily';

    case WEEKLY = 'weekly';

    case MONTHLY = 'monthly';

    public function label(): string
    {
        return Str::headline($this->value);
    }

    public function interval(): CarbonInterval
    {
        return match($this) {
            self::SINGLE => CarbonInterval::days(1),
            self::DAILY => CarbonInterval::days(1),
            self::WEEKLY => CarbonInterval::weeks(1),
            self::MONTHLY => CarbonInterval::months(1),
        };
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
                self::SINGLE->toResource(),
                self::DAILY->toResource(),
                self::WEEKLY->toResource(),
                self::MONTHLY->toResource(),
            ]
        );
    }
}
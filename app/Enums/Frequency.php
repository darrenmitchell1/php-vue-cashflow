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

    public function interval(int $numberOfUnits = 1): CarbonInterval
    {
        return match($this) {
            self::SINGLE => CarbonInterval::days($numberOfUnits),
            self::DAILY => CarbonInterval::days($numberOfUnits),
            self::WEEKLY => CarbonInterval::weeks($numberOfUnits),
            self::MONTHLY => CarbonInterval::months($numberOfUnits),
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
<?php

namespace App\Enums;

use Carbon\CarbonInterval;
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
}

<?php

namespace App\Enums;

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
}

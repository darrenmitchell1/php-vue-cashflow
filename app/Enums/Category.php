<?php

namespace App;

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
}

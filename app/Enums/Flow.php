<?php

namespace App\Enums;

enum Flow: string
{
    case IN = 'in';

    case OUT = 'out';

    public function label(): string
    {
        return Str::headline($this->value);
        
    }
}

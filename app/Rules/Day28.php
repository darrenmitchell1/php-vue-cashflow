<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Throwable;

class Day28 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (Carbon::parse($value)->day > 28) {
                $fail('The :attribute day must be 28 or less.');
            }
        } catch (Throwable $e) {
            $fail('The :attribute is not a validate date format.');
        }
    }
}

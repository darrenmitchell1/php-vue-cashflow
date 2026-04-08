<?php

namespace App\Rules;

use App\Models\ItemType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

class ItemTypeNameUnique implements ValidationRule
{
    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        // Handle if $ignoreId is a Model instance or a raw ID
        $this->ignoreId = $ignoreId instanceof ItemType ? $ignoreId->uuid : $ignoreId;
    }

    /**
     * Run the validation rule.
     * 
     * Using custom validate rule so can sanitize input for query
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = ItemType::query()
            ->withTrashed()
            ->whereRaw("LOWER(REPLACE(name, ' ', '')) = :val", ['val' => strtolower(str_replace(' ', '', $value))]);
        
        // Apply Ignore
        if (Str::isUlid($this->ignoreId)) {
            $query->where('uuid', '!=', $this->ignoreId);
        } elseif (is_int($this->ignoreId)) {
            $query->where('id', '!=', $this->ignoreId);
        }

        $exists = $query->exists();

        if ($exists) {
            $fail('The selected :attribute has already been taken');
        }
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\Flow;
use App\Enums\Frequency;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_type_id' => 'required|uuid|exists:App\Models\ItemType,uuid',
            'flow' => ['required', 'string', Rule::enum(Flow::class)],
            'frequency' => ['required', 'string', Rule::enum(Frequency::class)],
            'start_date' => 'required|date:Y-m-d',
            'end_date' => 'required|date:Y-m-d',
            'description' => 'required|string|max:2000',
            'company_name' => 'required|string|max:255',
            'amount' => 'required|decimal:2',
            'reference' => 'nullable|string|max:255',
        ];
    }
}

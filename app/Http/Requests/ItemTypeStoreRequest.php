<?php

namespace App\Http\Requests;

use App\Enums\Category;
use App\Rules\ItemTypeNameUnique;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemTypeStoreRequest extends FormRequest
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
            'category' => ['required', 'string', Rule::enum(Category::class)],
            'code' => 'required|string|max:255|alpha_dash|lowercase|unique:App\Models\ItemType,code',
            'name' => ['required', 'string', 'max:255', new ItemTypeNameUnique],
            'description' => 'required|string|max:2000',
        ];
    }
}

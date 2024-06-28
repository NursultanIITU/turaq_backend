<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'query' => 'nullable|string',
            'distance' => 'nullable|integer',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'city_id' => 'nullable|integer|exists:cities,id',
            'object_type_id' => 'nullable|integer|exists:object_types,id',
            'deal_type_id' => 'nullable|integer|exists:deal_types,id',
            'tariff_type_id' => 'nullable|integer|exists:tariff_types,id',
            'parking_space_size_id' => 'nullable|integer|exists:parking_space_sizes,id',
            'parking_space_number_id' => 'nullable|integer|exists:parking_space_numbers,id',
            'parking_type_id' => 'nullable|integer|exists:parking_types,id',
            'characteristic_ids' => 'nullable|array',
            'characteristic_ids.*' => 'nullable|integer|exists:characteristics,id',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'min_area' => 'nullable|numeric',
            'max_area' => 'nullable|numeric',
        ];
    }
}

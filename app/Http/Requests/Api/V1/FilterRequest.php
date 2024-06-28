<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'query' => 'required|string',
            'distance' => 'nullable|integer',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'city_id' => 'nullable|integer|exists:cities,id',
            'object_type_id' => 'nullable|integer|exists:object_types,id',
            'deal_type_id' => 'nullable|integer|exists:deal_types,id',
            'tariff_type_id' => 'nullable|integer|exists:tariff_types,id',
            'parking_space_size_id' => 'nullable|integer|exists:parking_space_sizes,id',
            'parking_space_number_id' => 'nullable|integer|exists:parking_space_numbers,id',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'min_area' => 'nullable|numeric',
            'max_area' => 'nullable|numeric',
        ];
    }
}
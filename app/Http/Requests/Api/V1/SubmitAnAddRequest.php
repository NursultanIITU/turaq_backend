<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitAnAddRequest extends FormRequest
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
            'name' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'city_id' => 'required|integer|exists:cities,id',
            'object_type_id' => 'required|integer|exists:object_types,id',
            'deal_type_id' => 'required|integer|exists:deal_types,id',
            'tariff_type_id' => 'required|integer|exists:tariff_types,id',
            'parking_space_size_id' => 'required|integer|exists:parking_space_sizes,id',
            'parking_space_number_id' => 'required|integer|exists:parking_space_numbers,id',
            'parking_type_id' => 'required|integer|exists:parking_types,id',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'characteristics_ids' => 'required|array',
            'characteristics_ids.*' => 'required|exists:characteristics,id',
            'description' => 'required|string',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|mimes:jpg,jpeg,png,gif|max:12000'
        ];
    }
}

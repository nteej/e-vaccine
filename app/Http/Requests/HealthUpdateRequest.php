<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'health_conditions' => ['nullable', 'array'],
            'health_conditions.*' => ['exists:health_conditions,id'],
            'allergies' => ['nullable', 'array'],
            'allergies.*' => ['string', 'max:255'],
            'medications' => ['nullable', 'array'],
            'medications.*' => ['string', 'max:255'],
            'is_pregnant' => ['nullable', 'boolean'],
            'is_healthcare_worker' => ['nullable', 'boolean'],
            'primary_physician' => ['nullable', 'string', 'max:255']
        ];
    }
}

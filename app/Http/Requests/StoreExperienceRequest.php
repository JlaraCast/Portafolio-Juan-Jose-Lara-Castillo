<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'company.es' => 'required|string|max:255',
            'company.en' => 'required|string|max:255',
            'role.es' => 'required|string|max:255',
            'role.en' => 'required|string|max:255',
            'period.es' => 'required|string|max:255',
            'period.en' => 'required|string|max:255',
            'location.es' => 'required|string|max:255',
            'location.en' => 'required|string|max:255',
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=500,max_height=500',
            'type' => 'required|in:work,education',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company.es.required' => 'The Spanish company name is required.',
            'company.en.required' => 'The English company name is required.',
            'role.es.required' => 'The Spanish role is required.',
            'role.en.required' => 'The English role is required.',
            'period.es.required' => 'The Spanish period is required.',
            'period.en.required' => 'The English period is required.',
            'location.es.required' => 'The Spanish location is required.',
            'location.en.required' => 'The English location is required.',
            'description.es.required' => 'The Spanish description is required.',
            'description.en.required' => 'The English description is required.',
            'logo.image' => 'The logo must be an image.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'logo.dimensions' => 'The logo dimensions must not exceed 500x500 pixels.',
            'type.required' => 'The experience type is required.',
            'type.in' => 'The type must be either work or education.',
            'skills.*.exists' => 'One or more selected skills do not exist.',
        ];
    }
}

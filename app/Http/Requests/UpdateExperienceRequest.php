<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
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
            'logo_url_input' => 'nullable|url|max:255',
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
        return [];
    }
}

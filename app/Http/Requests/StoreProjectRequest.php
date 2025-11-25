<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title_es' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=2000,max_height=2000',
            'image_url_input' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'live_url' => 'nullable|url|max:255',
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
        return [
            'title_es.required' => 'The Spanish title is required.',
            'title_en.required' => 'The English title is required.',
            'description_es.required' => 'The Spanish description is required.',
            'description_en.required' => 'The English description is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'image.max' => 'The image may not be greater than 2MB.',
            'image.dimensions' => 'The image dimensions must not exceed 2000x2000 pixels.',
            'skills.*.exists' => 'One or more selected skills do not exist.',
        ];
    }
}

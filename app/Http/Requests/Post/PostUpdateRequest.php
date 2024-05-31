<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string',
            'body' => 'sometimes|required|string',
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|string|max:255'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return string[]
     *
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
            'tags.array' => 'Tags must be an array',
            'tags.*.string' => 'Tags must be a string',
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'preview_image' => 'nullable',
            'product_images' => 'array|nullable',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
            'is_published' => 'nullable|integer',
            'category_id' => 'required|integer',
            'tags' => 'nullable|array',
        ];
    }
}

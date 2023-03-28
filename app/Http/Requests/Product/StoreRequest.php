<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'preview_image' => 'required',
            'product_images' => 'array|nullable',
            'price' => 'required|string',
            'count' => 'required|string',
            'is_published' => 'nullable|integer',
            'category_id' => 'required|integer',
            'tags' => 'nullable|array',
        ];
    }
}

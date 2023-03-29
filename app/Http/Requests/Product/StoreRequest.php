<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'preview_image' => [
                'required',
                File::image()
//                    ->min(1024)
//                    ->max(12 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(1000)),
            ],
            'product_images' => [
                'nullable',
                'array',
            ],
            'product_images.*' => [
                File::image()
//                    ->min(1024)
//                    ->max(12 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(1000)),
            ],
            'price' => 'required|string',
            'count' => 'required|string',
            'is_published' => 'nullable|integer',
            'category_id' => 'required|integer',
            'tags' => 'nullable|array',
        ];
    }
}

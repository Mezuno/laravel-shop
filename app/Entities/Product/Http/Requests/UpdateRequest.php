<?php

namespace App\Entities\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'preview_image' => [
                'nullable',
                File::image()
//                    ->min(1024)
//                    ->max(12 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(1000)),
            ],
            'price' => 'required|numeric',
            'count' => 'required|numeric',
            'is_published' => 'nullable|string',
            'category_id' => 'required|integer',
            'tags' => 'nullable|array',
        ];
    }
}

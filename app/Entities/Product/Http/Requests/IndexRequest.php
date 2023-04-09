<?php

namespace App\Entities\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'vendor_code' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:255',
            'is_not_published' => 'nullable|string',
            'is_published' => 'nullable|string',
            'price_from' => 'nullable|integer',
            'price_to' => 'nullable|integer',
            'size' => 'nullable|integer|max:255',
            'deleted' => 'nullable|string|max:255',
        ];
    }
}

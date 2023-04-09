<?php

namespace App\Entities\Review\Http\Requests;

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
            'user' => 'nullable|string',
            'product' => 'nullable|string',
            'title' => 'nullable|string',
            'rate_from' => 'nullable|integer',
            'rate_to' => 'nullable|integer',
            'confirmed_true' => 'nullable|string',
            'confirmed_false' => 'nullable|string',
            'size' => 'nullable|integer',
            'deleted' => 'nullable|string',
        ];
    }
}

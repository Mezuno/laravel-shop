<?php

namespace App\Entities\Order\Http\Requests;

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
            'total_price_from' => 'nullable|integer',
            'total_price_to' => 'nullable|integer',
            'payment_status_true' => 'nullable|string',
            'payment_status_false' => 'nullable|string',
            'size' => 'nullable|integer|max:255',
            'product' => 'nullable|string',
            'products_count' => 'nullable|integer',
            'deleted' => 'nullable|string|max:255',
        ];
    }
}

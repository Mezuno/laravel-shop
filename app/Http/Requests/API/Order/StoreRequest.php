<?php

namespace App\Http\Requests\API\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'products' => 'required|array',
            'name' => [
                'required',
                'max:70',
                "regex:/^(([a-zA-Z'-]{1,70})|([а-яА-ЯЁё'-]{1,70}))$/u"
            ],
            'email' => [
                'required',
                'email:rfc,dns',
            ],
            'address' => 'required|string',
            'total_price' => 'required|integer',
        ];
    }
}

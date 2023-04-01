<?php

namespace App\Entities\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
            'name' => [
                'required',
                'max:70',
                "regex:/^(([a-zA-Z'-]{1,70})|([а-яА-ЯЁё'-]{1,70}))$/u"
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->route('id'), 'user_id'),
                'email:rfc,dns',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->symbols()
                    ->uncompromised()
                    ->numbers()
                    ->mixedCase(),
            ],
            'surname' => [
                'nullable',
                'max:70',
                "regex:/^(([a-zA-Z'-]{1,70})|([а-яА-ЯЁё'-]{1,70}))$/u"
            ],
            'patronymic' => [
                'nullable',
                'max:70',
                "regex:/^(([a-zA-Z'-]{1,70})|([а-яА-ЯЁё'-]{1,70}))$/u"
            ],
            'age' => 'nullable|integer|min:0|max:150',
            'address' => 'nullable|string',
            'gender' => 'nullable|integer',
        ];
    }
}

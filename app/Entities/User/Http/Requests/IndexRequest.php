<?php

namespace App\Entities\User\Http\Requests;

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
            'id' => 'nullable|integer',
            'name' => 'nullable|string',
            'surname' => 'nullable|string',
            'patronymic' => 'nullable|string',
            'email' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|integer',
            'size' => 'nullable|integer',
            'deleted' => 'nullable|string',
        ];
    }
}

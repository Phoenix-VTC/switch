<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParseTrucksbookUserIdRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'TrucksBook User ID',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'numeric', 'min:1'],
            'username' => ['required', 'string'],
        ];
    }
}

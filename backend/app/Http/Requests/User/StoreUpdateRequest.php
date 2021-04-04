<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUpdateRequest extends FormRequest
{
    const MODEL_NAME = 'user';

    const VALIDATION_RULES = [
        'email'         => ['required', 'email', 'unique:users,email'],
        'name'          => ['required', 'string'],
        'password'      => ['nullable', 'string', 'between:8,32'],
        'departments'   => ['nullable', 'array'],
        'departments.*' => ['nullable', 'exists:departments,id']
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = static::VALIDATION_RULES;

        // update request
        if ($this->getMethod() === 'PATCH')
            $rules['email'][2] .= ",{$this->route(static::MODEL_NAME)->getKey()}";

        return $rules;
    }
}

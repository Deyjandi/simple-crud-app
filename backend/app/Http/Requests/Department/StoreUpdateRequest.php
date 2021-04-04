<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUpdateRequest extends FormRequest
{
    const MODEL_NAME = 'department';

    const VALIDATION_RULES = [
        'name'          => ['required', 'string', 'unique:departments,name'],
        'description'   => ['required', 'string'],
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
            $rules['name'][2] .= ",{$this->route(static::MODEL_NAME)->getKey()}";

        return $rules;
    }
}

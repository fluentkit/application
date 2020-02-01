<?php

namespace FluentKit\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::exists('users')
            ],
            'token' => [
                'required',
                'string',
                Rule::exists('users', 'reset_token')
            ],
            'password' => [
                'required',
                'string',
                'min:10',
                'confirmed'
            ],
        ];
    }
}

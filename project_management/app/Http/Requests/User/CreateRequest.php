<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
            ],
            'email' => [
                'bail',
                'required',
            ],
            'username' => [
                'bail',
                'required',
                'unique:App\Models\User,username'
            ],
            'password' => [
                'bail',
                'required',
                'max:100',
                'min:3',
            ],
            'confirmPassword' => [
                'bail',
                'required',
                'same:password',
            ],
        ];
    }
    /**
     * Get the validation message that return after request.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'required' => ':attribute is required',
        ];
    }
    public function attributes() : array
    {
        return [
            'name' => 'Staff\'s Name',
            'email' => 'Email',
            'password' => 'Password',
            'username' => 'Username',
        ];
    }
}

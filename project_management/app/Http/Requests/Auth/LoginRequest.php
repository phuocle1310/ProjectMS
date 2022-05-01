<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            'username' => [
                'bail',
                'required',
                Rule::exists(User::class, 'username')
            ],
            'password' => [
                'bail',
                'required',
                'max:10',
                'min:3',
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
            "exists" => ":attribute isn'\t exist",
        ];
    }
    public function attributes() : array
    {
        return [
            'password' => 'Password',
            'username' => 'Username',
        ];
    }
}

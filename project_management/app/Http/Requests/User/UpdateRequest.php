<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        dd($this->userId);
        return [
            'name' => [
                'bail',
                'required',
                'string',
            ],
            'email' => [
                'bail',
                'required',
                Rule::unique(User::class)->ignore($this->userId),
            ],
            'password' => [
                'bail',
                'required',
                'max:100',
                'min:3',
            ],
        ];
    }
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

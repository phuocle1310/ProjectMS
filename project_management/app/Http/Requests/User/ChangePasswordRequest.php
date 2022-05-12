<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\ChangePassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
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
        $currentPassword = $this->password;
        $userid = $this->userId;
        // dd($currentPassword);
        return [
            'password' => [
                'bail',
                'required',
                'max:100',
                'min:3',
                new ChangePassword($this->userId, $this->password),
            ],
            'newPassword' => [
                'bail',
                'required',
                'max:100',
                'min:3',
            ],
            'confirmPassword' => [
                'bail',
                'required',
                'same:newPassword',
            ],
        ];
    }
    public function messages() : array
    {
        return [
            'required' => ':attribute is required',
            'exists' => ':attribute is incorrect'
        ];
    }
    public function attributes() : array
    {
        return [
            'confirmPassword' => 'Confirm Password',
            'password' => 'Current Password',
            'newPassword' => 'New Password',
        ];
    }
}

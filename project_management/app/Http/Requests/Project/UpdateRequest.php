<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use App\Rules\UpdateDeadline;
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
        return [
            'project' => [
                'bail',
                'required',
                'string',
                Rule::unique(Project::class)->ignore($this->id),
            ],
            'description' => [
                'bail',
                'required',
                'string'
            ],
            'deadline' => [
                'bail',
                'required',
                new UpdateDeadline($this->id),
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
            'project' => 'Project',
            'mission' => 'Mission',
            'description' => 'Description',
        ];
    }
}

<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use App\Rules\DeleteProject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteRequest extends FormRequest
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
            'projectId' => [
                'required',
                Rule::exists(Project::class, 'id'),
                new DeleteProject($this->id),
            ],
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge(['projectId' => $this->route('projectId')]);
    }
}

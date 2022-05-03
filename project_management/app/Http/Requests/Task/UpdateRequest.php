<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
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
        $projectid = $this->projectid;
        $userid = $this->userid;
        // dd($this->userid);
        return [
            'userid' => [
                'bail',
                'required',
                'gt:0',
                Rule::unique(Task::class)->where(function ($query) use($projectid, $userid) {
                    return $query->where('projectid', $projectid)->where('userid', $userid);
                  })->ignore($this->id),
            ],
            'description' => [
                'bail',
                'required',
                'string'
            ],
            'mission' => [
                'bail',
                'required',
                'string'
            ],
        ];
    }

    public function messages() : array
    {
        return [
            'required' => ':attribute is required',
            'unique' => ':attribute has already been taken with this :other',
            'gt' => ':attribute is not exist',
        ];
    }
    
    public function attributes() : array
    {
        return [
            'projectid' => 'Project',
            'userid' => 'Staff\'s Name',
            'mission' => 'Mission',
            'description' => 'Description',
        ];
    }
}

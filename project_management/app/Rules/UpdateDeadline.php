<?php

namespace App\Rules;

use App\Models\Project;
use Illuminate\Contracts\Validation\Rule;

class UpdateDeadline implements Rule
{
    private $projectId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $object = Project::query()->find($this->projectId);
        if($object->process != 100) {
            if(strtotime($object->deadline) <= strtotime($value)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            if(strtotime($object->deadline) == strtotime($value))
                return true;
            else
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $object = Project::query()->find($this->projectId);
        if($object->process != 100) {
            return 'The :attribute must be greater than current deadline.';
        }
        else {
            return "The :attribute can't update because this project was finished.";
        }
        
    }
}

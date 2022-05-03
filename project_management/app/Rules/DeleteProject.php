<?php

namespace App\Rules;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Validation\Rule;

class DeleteProject implements Rule
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
        $objects = Task::query()->where('projectid', $this->projectId)->get();
        if(count($objects) == 0) {
            return true;
        }
        else {
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
        return 'You must delete tasks of this project first.';
    }
}

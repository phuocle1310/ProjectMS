<?php

namespace App\Policies\User;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user)
    {
        dd("$user->role->role");
        // return $user->role->role === 'root';
        return true;
    }
}

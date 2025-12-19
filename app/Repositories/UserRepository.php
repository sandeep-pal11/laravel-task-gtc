<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::with('roles')->select('users.*');
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}

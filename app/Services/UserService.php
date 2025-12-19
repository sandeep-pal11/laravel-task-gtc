<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // ✅ ADD THIS METHOD
    public function syncRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}

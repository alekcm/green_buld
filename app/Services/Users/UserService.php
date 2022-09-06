<?php

namespace App\Services\Users;

use App\Exceptions\BusinessLogicException;
use App\Models\User;

class UserService
{
    /**
     * @param User $user
     * @param array $data
     * @return User
     * @throws BusinessLogicException
     */
    public function update(User $user, array $data): User
    {
        if (!$user->update($data)) {
            throw new BusinessLogicException(trans('message.user.save_error'));
        }

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws BusinessLogicException
     */
    public function toggleBlock(User $user): User
    {
        $isBlocked = $user->is_blocked;
        if (!$user->update(['is_blocked' => !$isBlocked])) {
            throw new BusinessLogicException(trans('message.user.save_error'));
        }
        return $user;
    }
}

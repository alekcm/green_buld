<?php

namespace App\Services\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Exception;

class ForgotPasswordService
{
    /**
     * @param string $email
     * @return bool
     * @throws ModelNotFoundException
     */
    public function sendPassword(string $email): bool
    {
        $user = $this->getUser($email);

        $password = $user->changePassword();

        try {
            $user->notify(new ForgotPasswordNotification($email, $password));
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * @param string $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUser(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new ModelNotFoundException(trans('exception.model_not_found', ['attribute' => 'User']));
        }

        return $user;
    }
}

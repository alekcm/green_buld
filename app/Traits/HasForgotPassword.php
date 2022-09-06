<?php

namespace App\Traits;

use App\Helpers\RandomHelper;
use Eloquent;

/**
 *
 * @mixin Eloquent
 */
trait HasForgotPassword
{
    public function changePassword(): string
    {
        $password = RandomHelper::generateRandomString(config('app.user.password.min'), false);

        $this->update([
            'password' => $password,
        ]);

        return $password;
    }
}

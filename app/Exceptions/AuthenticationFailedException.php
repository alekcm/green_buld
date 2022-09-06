<?php

namespace App\Exceptions;

class AuthenticationFailedException extends BusinessLogicException
{
    protected $message = 'Authentication failed.';
}

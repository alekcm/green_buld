<?php

namespace App\Exceptions;

class ModelNotFoundException extends BusinessLogicException
{
    protected $message = 'Model not found.';
}

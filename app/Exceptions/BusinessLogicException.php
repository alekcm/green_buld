<?php

namespace App\Exceptions;

use App\Enums\ResponseCodeEnum;
use Exception;
use Throwable;

class BusinessLogicException extends Exception
{
    /**
     * @var array|null
     */
    protected ?array $debug = [];

    /**
     * @var int
     */
    protected $code = ResponseCodeEnum::ERROR;

    public function __construct($message = "", array $debug = [], $code = 0, Throwable $previous = null)
    {
        $this->debug = $debug;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getDebug(): array
    {
        return $this->debug;
    }
}

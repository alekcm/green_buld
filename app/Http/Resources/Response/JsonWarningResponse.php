<?php

namespace App\Http\Resources\Response;

use App\Enums\ResponseCodeEnum;
use Illuminate\Contracts\Support\Arrayable;

class JsonWarningResponse implements Arrayable
{
    const DEFAULT_ERROR_MESSAGE = "An error occurred.";

    /**
     * @var array
     */
    private array $data;

    /**
     * @var string
     */
    private string $message;


    /**
     * @param array $data
     * @param string $message
     */
    public function __construct(array $data, string $message = self::DEFAULT_ERROR_MESSAGE)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $response = [
            'code' => ResponseCodeEnum::WARNING,
            'message' => $this->message,
        ];

        if (count($this->data)) {
            $response['data'] = $this->data;
        }

        return $response;
    }
}

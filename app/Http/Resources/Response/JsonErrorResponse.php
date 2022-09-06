<?php

namespace App\Http\Resources\Response;

use App\Enums\ResponseCodeEnum;
use Illuminate\Contracts\Support\Arrayable;

class JsonErrorResponse implements Arrayable
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
     * @var array
     */
    private array $debug;

    /**
     * @param array $data
     * @param string $message
     * @param array $debug
     */
    public function __construct(array $data, string $message = self::DEFAULT_ERROR_MESSAGE, array $debug = [])
    {
        $this->data = $data;
        $this->message = $message;
        $this->debug = $debug;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->withExtraData([
            'code' => ResponseCodeEnum::ERROR,
            'message' => $this->message,
        ]);
    }

    /**
     * @param array $responseBody
     * @return array
     */
    protected function withExtraData(array $responseBody): array
    {
        if (count($this->data)) {
            $responseBody['data'] = $this->data;
        }

        if (count($this->debug)) {
            $responseBody['debug'] = $this->debug;
        }

        return $responseBody;
    }
}

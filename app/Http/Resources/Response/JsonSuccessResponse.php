<?php

namespace App\Http\Resources\Response;

use App\Enums\ResponseCodeEnum;
use Illuminate\Contracts\Support\Arrayable;

class JsonSuccessResponse implements Arrayable
{
    /**
     * @var array $data
     */
    private array $data;

    /**
     * @var string|null $message
     */
    private ?string $message;

    public function __construct(array $data, ?string $message = null)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->message
            ? array_merge(
                [
                    'code' => ResponseCodeEnum::OK,
                    'message' => $this->message,
                ],
                $this->data ? ['data' => $this->data] : []
            )
            : $this->data;
    }
}

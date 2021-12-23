<?php

namespace Conlect\ImageIIIF\Exceptions;

class HttpException extends \RuntimeException implements ExceptionInterface
{
    private int $statusCode;

    public function __construct(int $statusCode, string $message = '', int $code = 0)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

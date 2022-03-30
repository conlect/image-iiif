<?php

namespace Conlect\ImageIIIF\Exceptions;

class BaseException extends \RuntimeException implements ExceptionInterface
{
    private int $statusCode;

    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}

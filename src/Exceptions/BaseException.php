<?php

namespace Conlect\ImageIIIF\Exceptions;

class BaseException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}

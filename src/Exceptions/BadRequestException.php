<?php

namespace Conlect\ImageIIIF\Exceptions;

class BadRequestException extends BaseException
{
    public function __construct(string $message = 'Bad Request', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}

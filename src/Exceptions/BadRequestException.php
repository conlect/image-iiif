<?php

namespace Conlect\ImageIIIF\Exceptions;

class BadRequestException extends BaseException
{
    public function __construct(string $message = 'Bad Request', int $code = 0)
    {
        parent::__construct(400, $message, $code);
    }
}

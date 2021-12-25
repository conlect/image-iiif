<?php

namespace Conlect\ImageIIIF\Exceptions;

class NotImplementedException extends BaseException
{
    public function __construct(string $message = 'Not Implemented', int $code = 501)
    {
        parent::__construct($message, $code);
    }
}

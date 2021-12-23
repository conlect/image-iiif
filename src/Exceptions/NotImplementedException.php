<?php

namespace Conlect\ImageIIIF\Exceptions;

class NotImplementedException extends BaseException
{
    public function __construct(string $message = 'Not Implemented', int $code = 0)
    {
        parent::__construct(501, $message, $code);
    }
}

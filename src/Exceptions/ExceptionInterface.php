<?php

namespace Conlect\ImageIIIF\Exceptions;

interface ExceptionInterface extends \Throwable
{
    public function getStatusCode(): int;
}
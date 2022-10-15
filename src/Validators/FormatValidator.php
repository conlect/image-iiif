<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class FormatValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function valid($format)
    {
        if (in_array($format, array_keys($this->config['mime']))) {
            return true;
        }

        throw new BadRequestException("Format $format is invalid.");
    }
}

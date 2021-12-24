<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class FormatValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function validate($format)
    {
        return in_array($format, array_keys($this->config['mime']));
    }
}

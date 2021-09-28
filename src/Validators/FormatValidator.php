<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;
use Intervention\Image\Image;

class FormatValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($format)
    {
        var_dump($format);
        return in_array($format, array_keys($this->config['mime']));
    }
}
